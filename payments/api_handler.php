<?php
// Disable error reporting for clean JSON output
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 0);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    exit();
}

// Check action
if (!isset($input['action'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Action not specified']);
    exit();
}

// Load environment variables
function loadEnvVariables() {
    // Check if running in production (environment variables)
    if (getenv('SF_CLIENT_ID')) {
        return; // Environment variables already set
    }
    
    // Load from .env file for local development
    $envFile = __DIR__ . '/config.env';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue; // Skip comments
            }
            list($name, $value) = explode('=', $line, 2);
            if (!getenv($name)) {
                putenv(trim($name) . '=' . trim($value));
            }
        }
    }
}

// Load configuration
loadEnvVariables();

// Salesforce API Configuration
define('SF_AUTH_URL', getenv('SF_AUTH_URL') ?: 'https://mahindralifespaces--sandbox.sandbox.my.salesforce.com/services/oauth2/token');
define('SF_BOOKING_URL', getenv('SF_BOOKING_URL') ?: 'https://mahindralifespaces--sandbox.sandbox.my.salesforce.com/services/apexrest/getBookingsforOnlinePayment');
define('SF_CLIENT_ID', getenv('SF_CLIENT_ID') ?: 'demo_client_id');
define('SF_CLIENT_SECRET', getenv('SF_CLIENT_SECRET') ?: 'demo_client_secret');
define('SF_USERNAME', getenv('SF_USERNAME') ?: 'demo_username');
define('SF_PASSWORD', getenv('SF_PASSWORD') ?: 'demo_password');

// SMS API Configuration
define('SMS_API_URL', getenv('SMS_API_URL') ?: 'https://api.equence.in/pushsms');
define('SMS_USERNAME', getenv('SMS_USERNAME') ?: 'demo_sms_user');
define('SMS_PASSWORD', getenv('SMS_PASSWORD') ?: 'demo_sms_pass');
define('SMS_TEMPLATE_ID', getenv('SMS_TEMPLATE_ID') ?: 'demo_template_id');
define('SMS_FROM', getenv('SMS_FROM') ?: 'DEMO');

// Email SMTP Configuration
define('EMAIL_SERVER', getenv('EMAIL_SERVER') ?: 'demo.server.com');
define('EMAIL_PORT', getenv('EMAIL_PORT') ?: 587);
define('EMAIL_USERNAME', getenv('EMAIL_USERNAME') ?: 'demo@example.com');
define('EMAIL_PASSWORD', getenv('EMAIL_PASSWORD') ?: 'demo_password');
define('EMAIL_FROM', getenv('EMAIL_FROM') ?: 'demo@example.com');
define('EMAIL_FROM_NAME', getenv('EMAIL_FROM_NAME') ?: 'Demo Company');

// OTP Configuration
define('OTP_LENGTH', 6);
define('OTP_EXPIRY_MINUTES', 10);

// Easebuzz API Configuration
define('EASEBUZZ_API_URL', getenv('EASEBUZZ_API_URL') ?: 'https://testdashboard.easebuzz.in/easycollect/v1/create');
define('EASEBUZZ_KEY', getenv('EASEBUZZ_KEY') ?: 'demo_key');
define('EASEBUZZ_SALT', getenv('EASEBUZZ_SALT') ?: 'demo_salt');
define('EASEBUZZ_SUB_MERCHANT_ID', getenv('EASEBUZZ_SUB_MERCHANT_ID') ?: 'demo_merchant');

/**
 * Authenticate with Salesforce and get access token
 */
function authenticateWithSalesforce() {
    $authUrl = SF_AUTH_URL . '?' . http_build_query([
        'grant_type' => 'password',
        'client_id' => SF_CLIENT_ID,
        'client_secret' => SF_CLIENT_SECRET,
        'username' => SF_USERNAME,
        'password' => SF_PASSWORD
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $authUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Cookie: BrowserId=7vI_6-X_EfC9WKWOVKAR8Q; CookieConsentPolicy=0:1; LSKey-c$CookieConsentPolicy=0:1'
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception("CURL Error: " . $error);
    }
    
    curl_close($ch);

    if ($httpCode !== 200) {
        throw new Exception("Authentication failed with HTTP code: " . $httpCode);
    }

    $authData = json_decode($response, true);
    
    if (!$authData || !isset($authData['access_token'])) {
        throw new Exception("Invalid authentication response");
    }

    return $authData['access_token'];
}

/**
 * Get booking details from Salesforce
 */
function getBookingDetails($accessToken, $mobileOrEmail) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, SF_BOOKING_URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken,
        'Cookie: BrowserId=7vI_6-X_EfC9WKWOVKAR8Q; CookieConsentPolicy=0:1; LSKey-c$CookieConsentPolicy=0:1'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'mobileORemail' => $mobileOrEmail
    ]));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception("CURL Error: " . $error);
    }
    
    curl_close($ch);

    if ($httpCode !== 200) {
        throw new Exception("Booking API failed with HTTP code: " . $httpCode);
    }

    $bookingData = json_decode($response, true);
    return $bookingData;
}

/**
 * Generate random OTP
 */
function generateOTP() {
    return str_pad(mt_rand(0, pow(10, OTP_LENGTH) - 1), OTP_LENGTH, '0', STR_PAD_LEFT);
}

/**
 * Send SMS with OTP
 */
function sendOTPSMS($phoneNumber, $otp) {
    // Ensure phone number starts with 91 for India
    $formattedPhone = $phoneNumber;
    if (!str_starts_with($phoneNumber, '91')) {
        $formattedPhone = '91' . ltrim($phoneNumber, '+91');
    }

    $message = "Dear customer, " . $otp . " is the OTP to fetch your booking details with Mahindra Lifespaces. OTP is valid for " . OTP_EXPIRY_MINUTES . " minutes only.";

    $postData = [
        'username' => SMS_USERNAME,
        'password' => SMS_PASSWORD,
        'tmplId' => SMS_TEMPLATE_ID,
        'from' => SMS_FROM,
        'to' => $formattedPhone,
        'text' => $message
    ];

    // Log SMS request
    logError('Attempting to send OTP SMS', ['phone' => $formattedPhone, 'otp' => $otp, 'request' => $postData]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, SMS_API_URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Cookie: cookiesession1=678A3EA8A8B4E5F5B76626387772B50F'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        logError('SMS CURL Error', ['error' => $error, 'phone' => $formattedPhone]);
        throw new Exception("SMS CURL Error: " . $error);
    }

    curl_close($ch);

    // Log SMS response
    logError('SMS API Response', ['httpCode' => $httpCode, 'response' => $response, 'phone' => $formattedPhone]);

    if ($httpCode !== 200) {
        throw new Exception("SMS API failed with HTTP code: " . $httpCode . " Response: " . $response);
    }

    $smsData = json_decode($response, true);
    return $smsData;
}

/**
 * Send OTP via Email using SMTP
 */
function sendOTPEmail($email, $otp) {
    // Log email sending attempt
    logError('Attempting to send OTP email', ['email' => $email, 'otp' => $otp]);

    $subject = 'Your OTP for Mahindra Lifespaces';
    $message = "Dear Customer,\r\n\r\n";
    $message .= $otp . " is your OTP to sign in to your Mahindra Lifespaces account.\r\n\r\n";
    $message .= "This OTP is valid for " . OTP_EXPIRY_MINUTES . " mins.\r\n\r\n";
    $message .= "Please do not share this OTP with anyone.\r\n\r\n";
    $message .= "Thank you,\r\n";
    $message .= "Mahindra Lifespaces Team";

    try {
        // Use SMTP directly for better control and debugging
        $result = sendEmailViaSMTP($email, $subject, $message);

        if ($result) {
            logError('Email sent successfully via SMTP', ['email' => $email]);
            return ['success' => true, 'message' => 'Email sent successfully via SMTP'];
        } else {
            throw new Exception('Failed to send email via SMTP');
        }
    } catch (Exception $e) {
        logError('Email sending failed', ['email' => $email, 'error' => $e->getMessage()]);
        throw new Exception('Email sending failed: ' . $e->getMessage());
    }
}

/**
 * Send email via SMTP using stream_socket_client
 */
function sendEmailViaSMTP($to, $subject, $message) {
    $smtpServer = EMAIL_SERVER;
    $smtpPort = EMAIL_PORT;
    $smtpUser = EMAIL_USERNAME;
    $smtpPass = EMAIL_PASSWORD;
    $from = EMAIL_FROM;
    $fromName = EMAIL_FROM_NAME;

    // Connect to SMTP server
    $socket = @stream_socket_client(
        "$smtpServer:$smtpPort",
        $errno,
        $errstr,
        30,
        STREAM_CLIENT_CONNECT
    );

    if (!$socket) {
        throw new Exception("Failed to connect to SMTP server: $errstr ($errno)");
    }

    // Read server response
    $response = fgets($socket, 515);
    if (substr($response, 0, 3) != '220') {
        fclose($socket);
        throw new Exception("SMTP server error: $response");
    }

    // Send EHLO command
    fputs($socket, "EHLO " . EMAIL_SERVER . "\r\n");
    $response = fgets($socket, 515);

    // Read multi-line EHLO response
    $supportsStartTLS = false;
    while (substr($response, 3, 1) == '-') {
        if (stripos($response, 'STARTTLS') !== false) {
            $supportsStartTLS = true;
        }
        $response = fgets($socket, 515);
    }

    // Enable STARTTLS if supported
    if ($supportsStartTLS) {
        fputs($socket, "STARTTLS\r\n");
        $response = fgets($socket, 515);

        if (substr($response, 0, 3) == '220') {
            // Upgrade to TLS connection
            stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);

            // Send EHLO again after STARTTLS
            fputs($socket, "EHLO " . EMAIL_SERVER . "\r\n");
            $response = fgets($socket, 515);

            // Read multi-line EHLO response again
            while (substr($response, 3, 1) == '-') {
                $response = fgets($socket, 515);
            }
        }
    }

    // Send AUTH LOGIN command
    fputs($socket, "AUTH LOGIN\r\n");
    $response = fgets($socket, 515);

    if (substr($response, 0, 3) != '334') {
        fclose($socket);
        throw new Exception("AUTH LOGIN failed: $response");
    }

    // Send username
    fputs($socket, base64_encode($smtpUser) . "\r\n");
    $response = fgets($socket, 515);

    if (substr($response, 0, 3) != '334') {
        fclose($socket);
        throw new Exception("Username authentication failed: $response");
    }

    // Send password
    fputs($socket, base64_encode($smtpPass) . "\r\n");
    $response = fgets($socket, 515);

    if (substr($response, 0, 3) != '235') {
        fclose($socket);
        throw new Exception("Password authentication failed: $response");
    }

    // Send MAIL FROM command
    fputs($socket, "MAIL FROM: <$from>\r\n");
    $response = fgets($socket, 515);

    if (substr($response, 0, 3) != '250') {
        fclose($socket);
        throw new Exception("MAIL FROM failed: $response");
    }

    // Send RCPT TO command
    fputs($socket, "RCPT TO: <$to>\r\n");
    $response = fgets($socket, 515);

    if (substr($response, 0, 3) != '250') {
        fclose($socket);
        throw new Exception("RCPT TO failed: $response");
    }

    // Send DATA command
    fputs($socket, "DATA\r\n");
    $response = fgets($socket, 515);

    if (substr($response, 0, 3) != '354') {
        fclose($socket);
        throw new Exception("DATA command failed: $response");
    }

    // Compose email headers and body
    $emailData = "From: $fromName <$from>\r\n";
    $emailData .= "To: <$to>\r\n";
    $emailData .= "Subject: $subject\r\n";
    $emailData .= "MIME-Version: 1.0\r\n";
    $emailData .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $emailData .= "Content-Transfer-Encoding: 7bit\r\n";
    $emailData .= "\r\n";
    $emailData .= $message . "\r\n";
    $emailData .= ".\r\n";

    // Send email data
    fputs($socket, $emailData);
    $response = fgets($socket, 515);

    if (substr($response, 0, 3) != '250') {
        fclose($socket);
        throw new Exception("Email sending failed: $response");
    }

    // Send QUIT command
    fputs($socket, "QUIT\r\n");
    fclose($socket);

    return true;
}

/**
 * Store OTP in session
 */
function storeOTPInSession($otp, $phoneNumber) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_phone'] = $phoneNumber;
    $_SESSION['otp_timestamp'] = time();
    $_SESSION['otp_attempts'] = 0;
}

/**
 * Validate OTP from session
 */
function validateOTP($inputOTP, $phoneNumber) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_timestamp']) || !isset($_SESSION['otp_phone'])) {
        return ['valid' => false, 'message' => 'No OTP session found. Please request a new OTP.'];
    }
    
    // Check if OTP is expired
    $currentTime = time();
    $otpTime = $_SESSION['otp_timestamp'];
    $expiryTime = OTP_EXPIRY_MINUTES * 60; // Convert minutes to seconds
    
    if (($currentTime - $otpTime) > $expiryTime) {
        // Clear expired OTP
        unset($_SESSION['otp'], $_SESSION['otp_timestamp'], $_SESSION['otp_phone'], $_SESSION['otp_attempts']);
        return ['valid' => false, 'message' => 'OTP has expired. Please request a new OTP.'];
    }
    
    // Check phone number match
    if ($_SESSION['otp_phone'] !== $phoneNumber) {
        return ['valid' => false, 'message' => 'Phone number mismatch. Please request a new OTP.'];
    }
    
    // Increment attempt counter
    $_SESSION['otp_attempts'] = ($_SESSION['otp_attempts'] ?? 0) + 1;
    
    // Check max attempts (optional security measure)
    if ($_SESSION['otp_attempts'] > 5) {
        unset($_SESSION['otp'], $_SESSION['otp_timestamp'], $_SESSION['otp_phone'], $_SESSION['otp_attempts']);
        return ['valid' => false, 'message' => 'Too many invalid attempts. Please request a new OTP.'];
    }
    
    // Validate OTP
    if ($_SESSION['otp'] === $inputOTP) {
        // Clear OTP after successful validation
        unset($_SESSION['otp'], $_SESSION['otp_timestamp'], $_SESSION['otp_phone'], $_SESSION['otp_attempts']);
        return ['valid' => true, 'message' => 'OTP verified successfully.'];
    }
    
    return ['valid' => false, 'message' => 'Invalid OTP. Please try again.'];
}

/**
 * Generate Easebuzz hash for payment request
 */
function generateEasebuzzHash($data) {
    $hashString = EASEBUZZ_KEY . '|' . 
                  $data['merchant_txn'] . '|' . 
                  $data['name'] . '|' . 
                  $data['email'] . '|' . 
                  $data['phone'] . '|' . 
                  $data['amount'] . '|' . 
                  $data['udf1'] . '|' . 
                  $data['udf2'] . '|' . 
                  $data['udf3'] . '|' . 
                  $data['udf4'] . '|' . 
                  $data['udf5'] . '|' . 
                  $data['message'] . '|' . 
                  EASEBUZZ_SALT;
    
    return hash('sha512', $hashString);
}

/**
 * Generate unique transaction ID
 */
function generateTransactionId() {
    return 'TXN_' . date('YmdHis') . '_' . mt_rand(1000, 9999);
}

/**
 * Create Easebuzz payment link
 */
function createEasebuzzPaymentLink($paymentData) {
    // Generate unique transaction ID
    $txnId = generateTransactionId();
    
    // Prepare Easebuzz data
    $easebuzzData = [
        'merchant_txn' => $txnId,
        'key' => EASEBUZZ_KEY,
        'email' => $paymentData['email'],
        'name' => $paymentData['customerName'],
        'amount' => number_format($paymentData['amount'], 2, '.', ''),
        'phone' => substr($paymentData['mobile'], -10), // Get last 10 digits
        'udf1' => $paymentData['projectName'],        // Project Name
        'udf2' => $paymentData['tower'],              // Tower name
        'udf3' => $paymentData['propertyName'],       // Property name
        'udf4' => $paymentData['bookingName'],        // Booking Name
        'udf5' => $paymentData['unitType'],           // Unit Type
        'message' => '',
        'expiry_date' => '31-03-2026',
        'sub_merchant_id' => EASEBUZZ_SUB_MERCHANT_ID,
        'operation' => [
            [
                'type' => 'sms',
                'template' => 'Default sms template'
            ],
            [
                'type' => 'email', 
                'template' => 'Default email template'
            ],
            [
                'type' => 'whatsapp',
                'template' => 'Default whatsapp template'
            ]
        ]
    ];
    
    // Generate hash
    $easebuzzData['hash'] = generateEasebuzzHash($easebuzzData);
    
    // Make API call to Easebuzz
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, EASEBUZZ_API_URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($easebuzzData));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception("Easebuzz CURL Error: " . $error);
    }
    
    curl_close($ch);
    
    if ($httpCode !== 200) {
        throw new Exception("Easebuzz API failed with HTTP code: " . $httpCode . " Response: " . $response);
    }
    
    $responseData = json_decode($response, true);
    
    if (!$responseData) {
        throw new Exception("Invalid response from Easebuzz API");
    }
    
    // Log the full response for debugging
    logError('Easebuzz API Response', ['response' => $responseData, 'request' => $easebuzzData]);
    
    return $responseData;
}

/**
 * Log errors for debugging
 */
function logError($message, $context = []) {
    $logEntry = date('Y-m-d H:i:s') . ' - ' . $message;
    if (!empty($context)) {
        $logEntry .= ' - Context: ' . json_encode($context);
    }
    error_log($logEntry . PHP_EOL, 3, 'api_errors.log');
}

// Main API handler
try {
    switch ($input['action']) {
        case 'sendOTP':
            if (!isset($input['mobileORemail']) || empty(trim($input['mobileORemail']))) {
                throw new Exception('Mobile number or email is required');
            }

            $mobileOrEmail = trim($input['mobileORemail']);

            // Clean phone number - remove spaces, hyphens, and country code prefix only
            $cleanedNumber = preg_replace('/[\s\-]/', '', $mobileOrEmail); // Remove spaces and hyphens
            $cleanedNumber = preg_replace('/^\+?91/', '', $cleanedNumber); // Remove +91 or 91 from start only

            // If it's a phone number, use it directly for OTP
            if (preg_match('/^[6-9]\d{9}$/', $cleanedNumber)) {
                // It's a phone number
                $phoneNumber = $cleanedNumber;
            } else {
                // It's an email - we'll send a mock OTP for now and handle verification differently
                // For email authentication, we'll use a dummy phone number for OTP storage
                $phoneNumber = 'email_auth';
            }
            
            // Store the contact info for later use in OTP verification
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_contact'] = $mobileOrEmail;
            $_SESSION['contact_type'] = preg_match('/^[6-9]\d{9}$/', $cleanedNumber) ? 'phone' : 'email';
            
            // Generate OTP
            $otp = generateOTP();
            
            if ($_SESSION['contact_type'] === 'phone') {
                // Store OTP in session and send SMS
                storeOTPInSession($otp, $phoneNumber);
                
                try {
                    $smsResult = sendOTPSMS($phoneNumber, $otp);
                    
                    echo json_encode([
                        'success' => true,
                        'message' => 'OTP sent successfully to your phone',
                        'otpSent' => true,
                        'phone' => $phoneNumber,
                        'contact' => $mobileOrEmail,
                        'contactType' => 'phone'
                    ]);
                } catch (Exception $smsError) {
                    logError('SMS sending failed: ' . $smsError->getMessage());
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to send OTP. Please try again.',
                        'otpSent' => false
                    ]);
                }
            } else {
                // For email, store OTP and send email
                storeOTPInSession($otp, 'email_auth');

                try {
                    $emailResult = sendOTPEmail($mobileOrEmail, $otp);

                    echo json_encode([
                        'success' => true,
                        'message' => 'OTP sent successfully to your email',
                        'otpSent' => true,
                        'phone' => 'email_auth',
                        'contact' => $mobileOrEmail,
                        'contactType' => 'email'
                    ]);
                } catch (Exception $emailError) {
                    logError('Email sending failed: ' . $emailError->getMessage());
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to send OTP to email. Please try again.',
                        'otpSent' => false
                    ]);
                }
            }
            break;
            
        case 'getBookings':
            if (!isset($input['mobileORemail']) || empty(trim($input['mobileORemail']))) {
                throw new Exception('Mobile number or email is required');
            }

            $mobileOrEmail = trim($input['mobileORemail']);
            
            // Step 1: Authenticate with Salesforce
            $accessToken = authenticateWithSalesforce();
            
            // Step 2: Get booking details
            $bookingDetails = getBookingDetails($accessToken, $mobileOrEmail);
            
            // Check if bookings were found
            $hasBookings = false;
            if (is_array($bookingDetails)) {
                $hasBookings = count($bookingDetails) > 0;
            } elseif (is_object($bookingDetails) || (is_array($bookingDetails) && !empty($bookingDetails))) {
                $hasBookings = true;
            }
            
            if ($hasBookings) {
                // Store booking details in session for later use
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['booking_details'] = $bookingDetails;
                $_SESSION['user_contact'] = $mobileOrEmail;
                
                // Step 3: Generate and send OTP if phone number is provided
                $phoneNumber = null;
                // Clean phone number - remove spaces, hyphens, and country code prefix only
                $cleanedBookingNumber = preg_replace('/[\s\-]/', '', $mobileOrEmail);
                $cleanedBookingNumber = preg_replace('/^\+?91/', '', $cleanedBookingNumber);

                if (preg_match('/^[6-9]\d{9}$/', $cleanedBookingNumber)) {
                    // It's a phone number
                    $phoneNumber = $cleanedBookingNumber;
                } else {
                    // It's an email, try to extract phone from booking details
                    $bookingData = json_decode($bookingDetails['message'] ?? '{}', true);
                    if (isset($bookingData['mobile'])) {
                        $extractedPhone = preg_replace('/[\s\-]/', '', $bookingData['mobile']);
                        $extractedPhone = preg_replace('/^\+?91/', '', $extractedPhone);
                        if (preg_match('/^[6-9]\d{9}$/', $extractedPhone)) {
                            $phoneNumber = $extractedPhone;
                        }
                    }
                }
                
                if ($phoneNumber) {
                    // Generate OTP
                    $otp = generateOTP();
                    
                    // Store OTP in session
                    storeOTPInSession($otp, $phoneNumber);
                    
                    // Send SMS
                    try {
                        $smsResult = sendOTPSMS($phoneNumber, $otp);
                        
                        echo json_encode([
                            'success' => true,
                            'message' => 'OTP sent successfully',
                            'otpSent' => true,
                            'phone' => $phoneNumber,
                            'bookings' => $bookingDetails,
                            'contact' => $mobileOrEmail
                        ]);
                    } catch (Exception $smsError) {
                        logError('SMS sending failed: ' . $smsError->getMessage());
                        echo json_encode([
                            'success' => false,
                            'message' => 'Failed to send OTP. Please try again.',
                            'otpSent' => false
                        ]);
                    }
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Phone number not found. Please enter a valid phone number.',
                        'otpSent' => false
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'No bookings found for this phone number or email address',
                    'bookings' => null,
                    'otpSent' => false
                ]);
            }
            break;
            
        case 'verifyOTP':
            if (!isset($input['otp']) || empty(trim($input['otp']))) {
                throw new Exception('OTP is required');
            }
            
            if (!isset($input['phoneNumber']) || empty(trim($input['phoneNumber']))) {
                throw new Exception('Phone number is required');
            }
            
            $inputOTP = trim($input['otp']);
            $phoneNumber = trim($input['phoneNumber']);
            
            $validation = validateOTP($inputOTP, $phoneNumber);
            
            if ($validation['valid']) {
                // OTP verification successful, now get booking details
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                
                // Get the original contact info (phone or email) from session
                $mobileOrEmail = $_SESSION['user_contact'] ?? $phoneNumber;
                
                try {
                    // Step 1: Authenticate with Salesforce
                    $accessToken = authenticateWithSalesforce();
                    
                    // Step 2: Get booking details
                    $bookingDetails = getBookingDetails($accessToken, $mobileOrEmail);
                    
                    // Check if bookings were found
                    $hasBookings = false;
                    if (is_array($bookingDetails)) {
                        $hasBookings = count($bookingDetails) > 0;
                    } elseif (is_object($bookingDetails) || (is_array($bookingDetails) && !empty($bookingDetails))) {
                        $hasBookings = true;
                    }
                    
                    if ($hasBookings) {
                        // Store booking details in session for later use
                        $_SESSION['booking_details'] = $bookingDetails;
                        
                        echo json_encode([
                            'success' => true,
                            'message' => $validation['message'],
                            'otpVerified' => true,
                            'bookings' => $bookingDetails,
                            'hasBookings' => true
                        ]);
                    } else {
                        echo json_encode([
                            'success' => true,
                            'message' => $validation['message'],
                            'otpVerified' => true,
                            'bookings' => null,
                            'hasBookings' => false,
                            'bookingMessage' => 'No bookings found for this phone number or email address'
                        ]);
                    }
                    
                } catch (Exception $bookingError) {
                    logError('Booking retrieval failed after OTP verification: ' . $bookingError->getMessage());
                    
                    // OTP was verified successfully but booking retrieval failed
                    echo json_encode([
                        'success' => true,
                        'message' => $validation['message'],
                        'otpVerified' => true,
                        'bookings' => null,
                        'hasBookings' => false,
                        'bookingMessage' => 'Unable to retrieve booking details. Please try again.'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => $validation['message'],
                    'otpVerified' => false
                ]);
            }
            break;
            
        case 'createPaymentLink':
            // Validate required fields
            $requiredFields = ['bookingId', 'bookingName', 'amount', 'customerName', 'email', 'mobile', 
                             'projectName', 'tower', 'propertyName', 'unitType'];
            
            foreach ($requiredFields as $field) {
                if (!isset($input[$field]) || empty(trim($input[$field]))) {
                    throw new Exception("Field '$field' is required for payment");
                }
            }
            
            // Validate amount
            $amount = floatval($input['amount']);
            if ($amount <= 0) {
                throw new Exception('Amount must be greater than 0');
            }
            
            // Validate email
            if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Invalid email address');
            }
            
            // Validate phone number (should be 10 digits after removing country code)
            $phone = preg_replace('/[^0-9]/', '', $input['mobile']);
            $phone = preg_replace('/^91/', '', $phone); // Remove country code if present
            if (strlen($phone) !== 10) {
                throw new Exception('Invalid phone number');
            }
            
            // Prepare payment data
            $paymentData = [
                'bookingId' => trim($input['bookingId']),
                'bookingName' => trim($input['bookingName']),
                'amount' => $amount,
                'customerName' => trim($input['customerName']),
                'email' => trim($input['email']),
                'mobile' => $phone,
                'projectName' => trim($input['projectName']),
                'tower' => trim($input['tower']),
                'propertyName' => trim($input['propertyName']),
                'unitType' => trim($input['unitType'])
            ];
            
            // Create payment link
            $easebuzzResponse = createEasebuzzPaymentLink($paymentData);
            
            // Check if payment URL was returned
            if (isset($easebuzzResponse['data']) && isset($easebuzzResponse['data']['payment_url'])) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Payment link created successfully',
                    'payment_url' => $easebuzzResponse['data']['payment_url'],
                    'transaction_id' => $easebuzzResponse['data']['id'] ?? null
                ]);
            } else {
                throw new Exception('Failed to create payment link: ' . json_encode($easebuzzResponse));
            }
            break;
            
        default:
            throw new Exception('Invalid action specified');
    }
    
} catch (Exception $e) {
    // Log the error
    logError('API Error: ' . $e->getMessage(), [
        'input' => $input,
        'trace' => $e->getTraceAsString()
    ]);
    
    // Return error response
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while processing your request. Please try again.',
        'error_details' => $e->getMessage() // Remove this in production
    ]);
}
?>