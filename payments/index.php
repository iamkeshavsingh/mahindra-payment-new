<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Georama:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />
  <title>Mahindra Lifespaces | Online Payment</title>

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: "Georama", sans-serif;
    }

    /* loader */
    .loader {
      width: 40px;
      height: 40px;
      border: 4px solid #ccc;
      border-top: 4px solid #000;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin: 20px auto;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    .banner-container {
      background-image: url("img/login.png");
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      width: 100%;
      height: 100vh;

      display: flex;
      flex-direction: column;
    }


    /* header */

    .header-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      padding-top: 28px;
      padding-left: 22px;
      padding-right: 44px;
    }

    .logo-mahindra {
      width: 367px;
    }

    .menus-mahindra {
      display: flex;
      align-items: center;
      gap: 80px;
    }

    .items-mahindra {
      display: flex;
      align-items: center;
      gap: 40px;
    }

    .items-mahindra-list {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .items-mahindra-list-title {
      color: white;
      font-size: 19px;
      font-weight: 500;
    }

    .items-mahindra-icons {
      display: flex;
      align-items: center;
      gap: 24px;
    }


    /* main container content */

    .main-container-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex: 1;

      padding-left: 79px;
      padding-right: 79px;
    }



    /* left container */
    .left-side-container {
      position: relative;
    }

    .left-side-title {
      width: 531px;
      font-weight: 600;
      font-size: 40px;
      color: white;
      margin: 0;
      line-height: none;
    }

    .left-side-description {
      width: 627px;
      font-weight: 400;
      font-size: 28px;
      color: white;
      margin: 0;
      padding-top: 35px;
    }

    .line-top-text {
      position: absolute;
      top: -39%;
      left: 20%;
    }

    .line-down-text {
      position: absolute;
      top: 24%;
      left: -80px;
    }


    /* right side */

    .right-side-container {
      background: #F5F5F5;
      border-radius: 25px;
      box-shadow: -41.87px 41.87px 41.87px 0px #FFFFFF1A inset;
      box-shadow: 41.87px -41.87px 41.87px 0px #A5A5A51A inset;
      backdrop-filter: blur(20.399999618530273px);
      padding: 39px 53px 27px;
      width: 584px;
    }

    /* step 1 */

    .step-1-title {
      font-weight: 600;
      font-size: 28px;
      color: black;
      margin: 0;
    }

    .step-1-description {
      margin: 0;
      padding-top: 9px;
      color: black;
      font-size: 18px;
      font-weight: 400px;
    }

    .step-1-form-container {
      padding-top: 42px;
    }

    .step-1-form-title {
      font-size: 17px;
      font-weight: 400;
      margin: 0;
      padding-bottom: 11px;
    }

    .step-1-form-title>span {
      color: #E31836;
      font-size: 17px;
      font-weight: 400;
    }

    .step-1-form-input {
      background: #D9D9D9;
      border-radius: 10px;
      padding: 10px 13px;
      color: #4C4C4C;
      width: 100%;
      outline: none;
      border: none
    }

    .step-1-form-or {
      padding-top: 24px;
      padding-bottom: 6px;
      margin: 0;
      color: black;
      font-weight: 400;
      font-size: 20px;
      text-align: center;
      width: 100%;
    }

    .step-1-button-section {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      padding-top: 70px;
      padding-bottom: 49px;
    }

    .step-1-submit-button {
      background: #000;
      border-radius: 30px;
      padding: 10px 20px;
      color: white;
      font-weight: 400;
      font-size: 19px;
      outline: none;
      border: none;
      margin: 0;
    }

    .step-1-how-it-works {
      color: #E31836;
      margin: 0;
      font-weight: 400;
      font-size: 19px;
      padding: 10px 20px;
      cursor: pointer;
    }

    .step-1-available {
      margin: 0;
      color: black;
      font-weight: 400;
      font-size: 18px;
      text-align: center;
      width: 100%;
    }

    .step-1-available>span {
      color: #E31836;
    }


    /* works */
    .step-1-works {
      position: absolute;
      top: 16px;
      right: 30px;
      margin: 0;
      font-size: 25px;
      color: black;
      cursor: pointer;
    }

    .step-1-lists {
      margin: 0;
      padding-top: 37px;
      padding-bottom: 62px;
      display: flex;
      flex-direction: column;
      gap: 36px;
    }

    .step-1-lists-items {
      font-size: 18px;
      font-weight: 500;
      color: black;
    }

    .step-1-works-description {
      margin: 0;
      font-size: 18px;
      font-weight: 400;
      padding-left: 30px;
      color: black;
    }

    .step-1-works-email {
      margin: 0;
      font-size: 18px;
      font-weight: 400;
      padding-left: 30px;
      padding-top: 34px;
      padding-bottom: 22px;
      color: #E31836;
    }

    .step-1-works-email>span {
      margin: 0;
      font-size: 18px;
      font-weight: 400;
      color: gray;
    }

    .step-1-works-phone {
      margin: 0;
      font-size: 18px;
      font-weight: 400;
      padding-left: 30px;
      padding-bottom: 48px;
      color: #E31836;
    }


    /* error */
    .error-message {
      color: #e74c3c;
      font-size: 12px;
      margin-top: 5px;
      display: none;
    }

    .hidden {
      display: none !important;
    }

    /* step 2 */
    .step-2-title {
      font-weight: 500;
      font-size: 26px;
      color: black;
      margin: 0;
      padding-bottom: 100px;
    }

    .otp-main-container {
      display: flex;
      justify-content: center;
      gap: 12px;
    }

    /* otp box */
    .otp-box {
      width: 45px;
      height: 45px;
      border: none;
      border-bottom: 2px solid #999;
      text-align: center;
      font-size: 20px;
      background: transparent;
      outline: none
    }

    .otp-error {
      text-align: center;
      width: 100%;
    }

    .otp-submit-button {
      padding-top: 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding-bottom: 52px;
    }


    /* step 3 */
    .full-width-mode {
      justify-content: center !important;
      width: 100%;
    }

    .full-width-mode .right-side-container {
      width: 100%;
    }

    .full-width-mode #leftContainer {
      display: none;
    }


    .booking-table-container {
      margin-bottom: 40px;
    }

    .booking-table {
      width: 100%;
      border-collapse: collapse;
      background: white;
    }

    .booking-table th,
    .booking-table td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: left;
      font-size: 14px;
    }

    .booking-table th {
      background: #efefef;
    }

    .booking-table input[type="radio"] {
      width: 18px;
      height: 18px;
    }

    .payment-section {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-top: 20px;
    }

    .pay-btn {
      margin-top: 15px;
      background: black;
      color: white;
      border: none;
      padding: 10px 25px;
      border-radius: 20px;
      cursor: pointer;
    }

    .support-box {
      width: 260px;
      font-size: 14px;
    }

    .support-email {
      color: #E31836;
      margin-top: 10px;
    }

    .support-phone {
      color: #E31836;
    }

    /* STEP 4 */

    .review-container {
      width: 100%;
    }

    .review-title {
      text-align: center;
      font-size: 34px;
      margin-bottom: 6px;
      font-weight: 500;
    }

    .review-subtitle {
      text-align: center;
      margin-bottom: 40px;
    }

    .review-section {
      margin-bottom: 40px;
    }

    .review-heading {
      font-weight: 600;
      margin-bottom: 12px;
    }

    .review-table {
      width: 1037px;
      border-collapse: collapse;
      background: white;
    }

    .review-table th,
    .review-table td {
      border: 1px solid #ccc;
      padding: 12px;
      font-size: 14px;
      font-weight: 500;
    }

    .review-table th {
      background: #efefef;
      font-weight: 500;
    }

    .review-buttons {
      display: flex;
      gap: 20px;
      margin-top: 30px;
    }

    .back-btn {
      background: #bfbfbf;
      border: none;
      padding: 10px 25px;
      border-radius: 20px;
      cursor: pointer;
    }

    .submit-btn {
      background: black;
      color: white;
      border: none;
      padding: 10px 30px;
      border-radius: 25px;
      cursor: pointer;
    }

    .review-footer {
      margin-top: 40px;
      display: flex;
      justify-content: space-between;
      gap: 40px;
    }

    .disclaimer {
      max-width: 520px;
      font-size: 14px;
    }

    .support {
      max-width: 260px;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <section>
    <div class="banner-container">

      <!-- header -->
      <div class="header-container">
        <img src="img/logo.png" alt="logo" class="logo-mahindra">
        <div class="menus-mahindra">

          <div class="items-mahindra">
            <!-- item 1 -->
            <div class="items-mahindra-list">
              <p class="items-mahindra-list-title">About Us</p>
              <img src="img/arrow.svg" alt="logo" class="icon-down-arrow">
            </div>

            <!-- item 2 -->
            <div class="items-mahindra-list">
              <p class="items-mahindra-list-title">Our Business</p>
              <img src="img/arrow.svg" alt="logo" class="icon-down-arrow">
            </div>

            <!-- item 3 -->
            <div class="items-mahindra-list">
              <p class="items-mahindra-list-title">Explore Home</p>
              <img src="img/arrow.svg" alt="logo" class="icon-down-arrow">
            </div>
          </div>

          <div class="items-mahindra-icons">
            <img src="img/phone.svg" alt="phone">
            <img src="img/search.svg" alt="search">
            <img src="img/menu.svg" alt="menu">
          </div>
        </div>
      </div>


      <!-- main content -->

      <div class="main-container-content">

        <!-- left side Content -->

        <div class="left-side-container" id="leftContainer">
          <p class="left-side-title">Fast, secure and hassle-free payments</p>
          <p class="left-side-description">Our secure and swift system helps with
            paying installments and clearing dues</p>

          <!-- lines -->
          <img src="img/top.svg" alt="top-line" class="line-top-text">
          <img src="img/down.svg" alt="down-line" class="line-down-text">
        </div>

        <div class="right-side-container">

          <!-- LOGIN CONTENT -->
          <!-- step 1 -->
          <div id="step1">
            <p class="step-1-title">Secure Login</p>
            <p class="step-1-description">
              Enter your registered email ID or phone number used at the time of property registration.
            </p>

            <div class="step-1-form-container">
              <p class="step-1-form-title"><span>*</span>Phone</p>
              <input type="tel" id="phoneInput" class="step-1-form-input" placeholder="+91 - 0000 0000 00">
              <div id="phoneError" class="error-message"></div>

              <p class="step-1-form-or">Or</p>

              <p class="step-1-form-title"><span>*</span>Email</p>
              <input id="emailInput" type="email" class="step-1-form-input"
                placeholder="Enter registered email address">
              <div id="emailError" class="error-message"></div>

              <div class="step-1-button-section">
                <button class="step-1-submit-button" onclick="generateOtp()">Generate OTP</button>
                <p class="step-1-how-it-works" onclick="showHowItWorks()">How It works ?</p>
              </div>

              <p class="step-1-available">
                <span>*</span>Available Payment Options: Net Banking & UPI
              </p>
            </div>
          </div>

          <!-- step 2 -->
          <div id="step2" class="hidden">

            <p class="step-2-title otpLabel" style="text-align:center">
              Please enter the 6-digit OTP sent to your registered email ID or mobile number.
            </p>

            <div class="otp-main-container">
              <input maxlength="1" class="otp-box">
              <input maxlength="1" class="otp-box">
              <input maxlength="1" class="otp-box">
              <input maxlength="1" class="otp-box">
              <input maxlength="1" class="otp-box">
              <input maxlength="1" class="otp-box">
            </div>

            <div id="otpError" class="error-message otp-error"></div>

            <div class="otp-submit-button">
              <button class="step-1-submit-button" onclick="verifyOtp()">Submit OTP</button>
              <p style="color:red; cursor:pointer" onclick="generateOtp()">Regenerate OTP</p>
            </div>

            <p class="step-1-available">
              <span>*</span>Available Payment Options: Net Banking & UPI
            </p>

          </div>

          <!-- step 3 -->
          <div id="step3" class="hidden">

            <p class="step-1-title" style="text-align:center; margin-bottom:30px;">
              Select the booking for payment
            </p>

            <div class="booking-table-container">

              <table class="booking-table">
                <thead>
                  <tr>
                    <th></th>
                    <th>Application No</th>
                    <th>Project Name</th>
                    <th>Tower</th>
                    <th>Unit Type</th>
                    <th>Property No</th>
                    <th>Outstanding</th>
                  </tr>
                </thead>

                <tbody id="propertyTableBody"></tbody>

              </table>

            </div>

            <div class="payment-section">

              <div>
                <p class="step-1-form-title"><span>*</span>Enter Amount to Pay</p>
                <input id="amountInput" class="step-1-form-input" type="number" placeholder="Enter amount">
                <button onclick="goReview()" class="pay-btn">Pay</button>
              </div>

              <div class="support-box">
                <p>
                  Need help? Our support team is available to assist you with any queries related to your transaction
                </p>

                <p class="support-email">✉ customercare@mahindralifespaces.in</p>
                <p class="support-phone">☎ 022 5016 4122</p>
              </div>

            </div>

            <p class="step-1-available">
              <span>*</span>Available Payment Options: Net Banking & UPI
            </p>

          </div>

          <!-- STEP 4 : PAYMENT REVIEW -->
          <div id="step4" class="hidden">

            <div class="review-container">

              <h2 class="review-title">Validate Booking & Payment Details</h2>
              <p class="review-subtitle">
                Please review the details before proceeding with the payment
              </p>

              <!-- Customer Details -->
              <div class="review-section">
                <p class="review-heading">Customer Details</p>

                <table class="review-table">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Mobile Number</th>
                      <th>Email id</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td id="customerName"></td>
                      <td id="customerMobile"></td>
                      <td id="customerEmail"></td>
                    </tr>
                  </tbody>
                </table>
              </div>


              <!-- Property Details -->
              <div class="review-section">
                <p class="review-heading">Property and Payment Details</p>

                <table class="review-table">
                  <thead>
                    <tr>
                      <th>Project</th>
                      <th>Tower</th>
                      <th>House/Unit No</th>
                      <th>Amount to Pay</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td id="selectedProject"></td>
                      <td id="selectedTower"></td>
                      <td id="selectedProperty"></td>
                      <td id="paymentAmount"></td>
                    </tr>
                  </tbody>
                </table>
              </div>


              <!-- Buttons -->
              <div class="review-buttons">
                <button class="back-btn" onclick="goBack()">Back</button>
                <button class="submit-btn" onclick="submitPayment()">Submit Payment</button>
              </div>


              <!-- Footer Info -->
              <div class="review-footer">

                <div class="disclaimer">
                  <b>Disclaimer:</b> You are being redirected to a secure payment gateway supported by Easebuzz.
                  Mahindra Lifespaces Developers Ltd does not collect or store your payment details at any stage.
                </div>

                <div class="support">
                  <p>Need help? Our support team is available to assist you with any queries related to your transaction
                  </p>
                  <p class="support-email">✉ customercare@mahindralifespaces.in</p>
                  <p class="support-phone">☎ 022 5016 4122</p>
                </div>

              </div>

              <p class="step-1-available">
                <span>*</span>Available Payment Options: Net Banking & UPI
              </p>

            </div>

          </div>


          <!-- LOADER -->
          <div id="loader" class="loader hidden"></div>

          <!-- HOW IT WORKS -->
          <div id="howItWorksView" style="display:none">

            <div>
              <p class="step-1-title">How It Works?</p>
              <p class="step-1-works" onclick="hideHowItWorks()">X</p>
            </div>

            <ol class="step-1-lists">
              <li class="step-1-lists-items">Login with your registered mobile number and validate using OTP.</li>
              <li class="step-1-lists-items">Select the booking for payment, enter the amount, and verify booking
                details.</li>
              <li class="step-1-lists-items">Click on "Pay Now".</li>
            </ol>

            <p class="step-1-works-description">
              Need help? Our support team is available to assist you with any queries related to your transaction
            </p>

            <p class="step-1-works-email"><span>✉</span>
              customercare@mahindralifespaces.in</p>
            <p class="step-1-works-phone">☎
              022 5016 4122</p>

            <p class="step-1-available">
              <span>*</span>Available Payment Options: Net Banking & UPI
            </p>

          </div>

        </div>

      </div>

    </div>
  </section>

  <script>


    // how it works
    function showHowItWorks() {
      document.getElementById("step1").style.display = "none";
      document.getElementById("howItWorksView").style.display = "block";
    }

    function hideHowItWorks() {
      document.getElementById("howItWorksView").style.display = "none";
      document.getElementById("step1").style.display = "block";
    }

    // Global variables for storing data
    let bookingDetails = null;
    let userPhoneNumber = null;

    // Validation functions
    function validatePhone(phone) {
      const phoneRegex = /^[6-9]\d{9}$/;
      return phoneRegex.test(phone.replace(/\s/g, ''));
    }

    function validateEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    }

    function showError(inputId, errorId, message) {
      const input = document.getElementById(inputId);
      const error = document.getElementById(errorId);

      input.classList.add('input-error');
      error.textContent = message;
      error.style.display = 'block';

      // hide after 2 seconds
      setTimeout(() => {
        error.style.display = 'none';
        input.classList.remove('input-error');
      }, 2000);
    }


    function hideError(inputId, errorId) {
      const input = document.getElementById(inputId);
      const error = document.getElementById(errorId);
      input.classList.remove('input-error');
      error.style.display = 'none';
    }

    //enter otp
    const otpInputs = document.querySelectorAll(".otp-box");

    otpInputs.forEach((input, index) => {

      input.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "");

        if (this.value && otpInputs[index + 1]) {
          otpInputs[index + 1].focus();
        }
      });

      input.addEventListener("keydown", function (e) {

        if (e.key === "Backspace" && !this.value && otpInputs[index - 1]) {
          otpInputs[index - 1].focus();
        }

      });

    });

    otpInputs[0].addEventListener("paste", function (e) {

      const pasteData = e.clipboardData.getData("text").trim();

      if (/^\d{6}$/.test(pasteData)) {

        otpInputs.forEach((input, i) => {
          input.value = pasteData[i];
        });

        otpInputs[5].focus();
      }

    });

    function validateInputs() {
      const phoneInput = document.getElementById('phoneInput');
      const emailInput = document.getElementById('emailInput');
      const phoneValue = phoneInput.value.trim();
      const emailValue = emailInput.value.trim();

      let isValid = true;

      // Reset previous errors
      hideError('phoneInput', 'phoneError');
      hideError('emailInput', 'emailError');

      // Check if both fields are empty
      if (!phoneValue && !emailValue) {
        showError('phoneInput', 'phoneError', 'Please enter either phone number or email address');
        showError('emailInput', 'emailError', 'Please enter either phone number or email address');
        return false;
      }

      // Validate phone if provided
      if (phoneValue) {
        if (!validatePhone(phoneValue)) {
          showError('phoneInput', 'phoneError', 'Invalid format. Please enter your registered phone number.');
          isValid = false;
        }
      }

      // Validate email if provided
      if (emailValue) {
        if (!validateEmail(emailValue)) {
          showError('emailInput', 'emailError', 'Invalid format. Please enter your registered email address.');
          isValid = false;
        }
      }

      return isValid;
    }


    async function generateOtp() {
      if (!validateInputs()) {
        return;
      }

      // Get the entered value (phone or email)
      const phoneValue = document.getElementById('phoneInput').value.trim();
      const emailValue = document.getElementById('emailInput').value.trim();
      const mobileOrEmail = phoneValue || emailValue;

      document.getElementById("step1").classList.add("hidden");
      document.getElementById("loader").classList.remove("hidden");

      try {
        // Call new sendOTP API
        const response = await fetch('api_handler.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            action: 'sendOTP',
            mobileORemail: mobileOrEmail
          })
        });

        if (!response.ok) {
          throw new Error(`Server error: ${response.status}`);
        }

        const result = await response.json();
        console.log('OTP send response:', result);

        if (result.success && result.otpSent) {
          // Store phone number/identifier for OTP verification
          userPhoneNumber = result.phone;

          // OTP sent successfully, proceed to OTP step
          document.getElementById("loader").classList.add("hidden");
          document.getElementById("step2").classList.remove("hidden");

          // Update OTP label based on contact type
          const otpLabel = document.querySelector('#step2 .otpLabel');
          if (result.contactType === 'email') {
            otpLabel.textContent = 'Please enter the 6-digit OTP sent to your registered email ID.';
          } else {
            otpLabel.textContent = 'Please enter the 6-digit OTP sent to your registered mobile number.';
          }
        } else {

          // document.getElementById("loader").classList.add("hidden");
          // document.getElementById("step2").classList.remove("hidden");

          // Failed to send OTP
          document.getElementById("loader").classList.add("hidden");
          document.getElementById("step1").classList.remove("hidden");
          alert(result.message || 'Failed to send OTP. Please try again.');
        }

      } catch (error) {

        // document.getElementById("loader").classList.add("hidden");
        // document.getElementById("step2").classList.remove("hidden");

        // console.error('API Error:', error);

        // Hide loader and show step1 again for API errors
        document.getElementById("loader").classList.add("hidden");
        document.getElementById("step1").classList.remove("hidden");
        alert('Failed to send OTP. Please check your connection and try again.');
      }
    }

    async function verifyOtp() {
      const otpValue = [...document.querySelectorAll(".otp-box")]
        .map(i => i.value)
        .join("");


      // Reset previous errors
      // hideError('otpInput', 'otpError');
      document.getElementById("otpError").style.display = "none";


      // Validate OTP
      if (!otpValue) {
        // showError('otpInput', 'otpError', 'Please enter the OTP');
        document.getElementById("otpError").textContent = 'Please enter the OTP';
        document.getElementById("otpError").style.display = "block";
        return;
      }

      if (otpValue.length !== 6 || !/^\d{6}$/.test(otpValue)) {
        // showError('otpInput', 'otpError', 'OTP entered is invalid');
        document.getElementById("otpError").textContent = 'OTP entered is invalid';
        document.getElementById("otpError").style.display = "block";
        return;
      }

      if (!userPhoneNumber) {
        showError('otpInput', 'otpError', 'Phone number not found. Please restart the process.');
        return;
      }

      // Show loader
      document.getElementById("step2").classList.add("hidden");
      document.getElementById("loader").classList.remove("hidden");

      try {
        const response = await fetch('api_handler.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            action: 'verifyOTP',
            otp: otpValue,
            phoneNumber: userPhoneNumber
          })
        });

        if (!response.ok) {
          throw new Error(`Server error: ${response.status}`);
        }

        const result = await response.json();
        console.log('OTP Verification response:', result);

        document.getElementById("loader").classList.add("hidden");

        if (result.success && result.otpVerified) {
          // OTP verified successfully, now check booking results
          if (result.hasBookings && result.bookings) {
            // Store booking details and show booking table
            bookingDetails = result.bookings;
            console.log('OTP verification successful. Booking details:', bookingDetails);
            showBookingTable();
          } else {
            // No bookings found - show no booking found screen
            console.log('OTP verified but no bookings found:', result.bookingMessage);
            document.getElementById("noBookingFound").classList.remove("hidden");

            // Update the no booking message if provided
            if (result.bookingMessage) {
              const noBookingElement = document.querySelector('#noBookingFound .otpLabel');
              if (noBookingElement) {
                noBookingElement.textContent = 'Booking Status : ' + result.bookingMessage;
              }
            }
          }
        } else {
          // showBookingTable();
          // OTP verification failed - ensure step2 is visible and show error
          document.getElementById("step2").classList.remove("hidden");
          document.getElementById("otpError").textContent =
            result.message || 'Invalid OTP. Please try again.';
          document.getElementById("otpError").style.display = "block";
        }

      } catch (error) {
        console.error('OTP Verification Error:', error);
        // showBookingTable();

        // Hide loader and show step2 again
        document.getElementById("step2").classList.remove("hidden");
      }
    }

    // Add blur event listeners for real-time validation
    document.addEventListener('DOMContentLoaded', function () {
      const phoneInput = document.getElementById('phoneInput');
      const emailInput = document.getElementById('emailInput');
      const otpInput = document.getElementById('otpInput');

      phoneInput.addEventListener('blur', function () {
        const value = this.value.trim();
        if (value && !validatePhone(value)) {
          showError('phoneInput', 'phoneError', 'Invalid format. Please enter your registered phone number.');
        } else if (value) {
          hideError('phoneInput', 'phoneError');
        }
      });

      emailInput.addEventListener('blur', function () {
        const value = this.value.trim();
        if (value && !validateEmail(value)) {
          showError('emailInput', 'emailError', 'Invalid format. Please enter your registered email address.');
        } else if (value) {
          hideError('emailInput', 'emailError');
        }
      });

      // Clear errors when user starts typing
      phoneInput.addEventListener('input', function () {
        if (this.classList.contains('input-error')) {
          hideError('phoneInput', 'phoneError');
        }
      });

      emailInput.addEventListener('input', function () {
        if (this.classList.contains('input-error')) {
          hideError('emailInput', 'emailError');
        }
      });

      // OTP input validation
      otpInput.addEventListener('input', function () {
        // Only allow numbers
        this.value = this.value.replace(/[^0-9]/g, '');

        // Clear errors when user starts typing
        if (this.classList.contains('input-error')) {
          hideError('otpInput', 'otpError');
        }
      });

      otpInput.addEventListener('blur', function () {
        const value = this.value.trim();
        if (value && (value.length !== 6 || !/^\d{6}$/.test(value))) {
          showError('otpInput', 'otpError', 'OTP entered is invalid');
        } else if (value) {
          hideError('otpInput', 'otpError');
        }
      });
    });

    // Function to show booking table after OTP verification
    function showBookingTable() {
      document.getElementById("step2").classList.add("hidden");
      document.getElementById("step3").classList.remove("hidden");

      // enable full width layout
      document.querySelector(".main-container-content")
        .classList.add("full-width-mode");
      populateBookingTable();
    }

    // Function to parse and populate booking data
    function populateBookingTable() {
      console.log("Populating booking table...");
      console.log("Raw booking details:", bookingDetails);

      const tbody = document.getElementById("propertyTableBody");
      if (!tbody) {
        console.error("Table body element not found!");
        return;
      }

      tbody.innerHTML = "";

      try {
        // Parse the nested JSON from bookingDetails.message
        let allBookings = [];
        let customerInfo = null;

        if (bookingDetails && bookingDetails.message) {
          console.log("Parsing booking message:", bookingDetails.message);

          // Split multiple JSON objects in the message (they are concatenated with spaces)
          const messageContent = bookingDetails.message.trim();
          console.log("Raw message content:", messageContent);

          // Try to extract multiple JSON objects by finding }{ pattern
          const jsonObjects = [];
          let startIndex = 0;
          let braceCount = 0;
          let inString = false;
          let escape = false;

          for (let i = 0; i < messageContent.length; i++) {
            const char = messageContent[i];

            if (escape) {
              escape = false;
              continue;
            }

            if (char === '\\') {
              escape = true;
              continue;
            }

            if (char === '"') {
              inString = !inString;
              continue;
            }

            if (inString) continue;

            if (char === '{') {
              braceCount++;
            } else if (char === '}') {
              braceCount--;
              if (braceCount === 0) {
                // Found complete JSON object
                const jsonStr = messageContent.substring(startIndex, i + 1);
                try {
                  const parsedObj = JSON.parse(jsonStr);
                  jsonObjects.push(parsedObj);
                  console.log("Parsed JSON object:", parsedObj);
                } catch (e) {
                  console.warn("Failed to parse JSON object:", jsonStr, e);
                }

                // Find start of next JSON object
                startIndex = i + 1;
                while (startIndex < messageContent.length && messageContent[startIndex] === ' ') {
                  startIndex++;
                }
                i = startIndex - 1; // -1 because loop will increment
              }
            }
          }

          console.log("Found", jsonObjects.length, "JSON objects");

          // Collect all bookings from all customer records
          jsonObjects.forEach((customerData, customerIndex) => {
            console.log(`Processing customer ${customerIndex}:`, customerData);

            // Use the first customer's info for display
            if (customerIndex === 0) {
              customerInfo = {
                customerName: customerData.customerName,
                mobile: customerData.mobile,
                email: customerData.email,
                customerId: customerData.CustomerId
              };
            }

            // Collect bookings from this customer
            if (customerData.bookingDetails && Array.isArray(customerData.bookingDetails)) {
              customerData.bookingDetails.forEach(booking => {
                allBookings.push({
                  ...booking,
                  customerName: customerData.customerName,
                  customerMobile: customerData.mobile,
                  customerEmail: customerData.email
                });
              });
            }
          });
        }

        console.log("Total bookings found:", allBookings.length);
        console.log("All bookings:", allBookings);

        if (allBookings.length > 0) {
          console.log("Processing booking details array:", allBookings.length, "items");

          allBookings.forEach((item, index) => {
            console.log(`Processing booking item ${index}:`, item);
            tbody.innerHTML += `
                <tr>
                  <td><input type="radio" name="property" data-booking-id="${item.bookingId || ''}" data-outstanding="${item.outstandingBalance || 0}" data-customer-name="${item.customerName || ''}" data-customer-mobile="${item.customerMobile || ''}" data-customer-email="${item.customerEmail || ''}"/></td>
                  <td>${item.bookingName || 'N/A'}</td>
                  <td>${item.projectName || 'N/A'}</td>
                  <td>${item.tower || 'N/A'}</td>
                  <td>${item.unitType || 'N/A'}</td>
                  <td>${item.propertyName || 'N/A'}</td>
                  <td>₹${parseFloat(item.outstandingBalance || 0).toLocaleString()}</td>
                </tr>
              `;
          });

          console.log("Table populated successfully with", allBookings.length, "items");

          // Store customer info for payment summary
          if (customerInfo) {
            window.selectedCustomerInfo = customerInfo;
          }

          // Add event listeners to radio buttons for amount auto-population
          addRadioButtonListeners();
        } else {
          console.log("No valid booking details found, showing fallback message");
          tbody.innerHTML = `
              <tr>
                <td colspan="8" style="text-align: center; padding: 20px; color: #666;">
                  No booking details available
                </td>
              </tr>
            `;
        }
      } catch (error) {
        console.error("Error parsing booking data:", error);
        tbody.innerHTML = `
            <tr>
              <td colspan="8" style="text-align: center; padding: 20px; color: #e74c3c;">
                Error loading booking details
              </td>
            </tr>
          `;
      }

      console.log("Final table HTML:", tbody.innerHTML);
    }

    // Function to add event listeners to radio buttons
    function addRadioButtonListeners() {
      const radioButtons = document.querySelectorAll('input[name="property"]');
      const amountInput = document.getElementById('amountInput');

      radioButtons.forEach(radio => {
        radio.addEventListener('change', function () {
          if (this.checked) {
            const outstandingAmount = this.getAttribute('data-outstanding');
            const bookingId = this.getAttribute('data-booking-id');

            console.log('Selected booking:', bookingId, 'Outstanding:', outstandingAmount);

            // Auto-populate amount field with outstanding balance
            if (outstandingAmount && amountInput) {
              // Remove commas and convert to number
              const numericAmount = parseFloat(outstandingAmount);
              amountInput.value = numericAmount;
              console.log('Amount field populated with:', numericAmount);
            }
          }
        });
      });

      console.log('Radio button listeners added to', radioButtons.length, 'buttons');
    }

    // Function to show payment summary and populate data
    function goReview() {
      const amountInput = document.getElementById('amountInput');
      const selectedRadio = document.querySelector('input[name="property"]:checked');

      if (!selectedRadio) {
        alert('Please select a booking.');
        return;
      }

      if (!amountInput.value || parseFloat(amountInput.value) <= 0) {
        alert('Please enter a valid amount to pay.');
        return;
      }

      console.log("Proceeding to payment review...");
      console.log("Selected booking ID:", selectedRadio.getAttribute('data-booking-id'));
      console.log("Payment amount:", amountInput.value);

      // Hide table step and show summary step
      document.getElementById("step3").classList.add("hidden");
      document.getElementById("step4").classList.remove("hidden");

      // keep full width layout
      document.querySelector(".main-container-content")
        .classList.add("full-width-mode");


      // Populate payment summary with data
      populatePaymentSummary(selectedRadio, amountInput.value);
    }

    // Function to populate payment summary with customer and property data
    function populatePaymentSummary(selectedRadio, paymentAmount) {
      try {
        console.log("Populating payment summary...");

        // Get customer and booking details from radio button data attributes
        const customerName = selectedRadio.getAttribute('data-customer-name');
        const customerMobile = selectedRadio.getAttribute('data-customer-mobile');
        const customerEmail = selectedRadio.getAttribute('data-customer-email');
        const selectedBookingId = selectedRadio.getAttribute('data-booking-id');

        console.log("Selected booking ID:", selectedBookingId);
        console.log("Customer data:", { customerName, customerMobile, customerEmail });

        // Find the booking details from the table row
        const selectedRow = selectedRadio.closest('tr');
        const cells = selectedRow.querySelectorAll('td');

        const projectName = cells[2] ? cells[2].textContent.trim() : 'N/A';
        const tower = cells[3] ? cells[3].textContent.trim() : 'N/A';
        const propertyName = cells[5] ? cells[5].textContent.trim() : 'N/A';

        console.log("Booking details:", { projectName, tower, propertyName });

        // Populate Customer Details
        document.getElementById('customerName').textContent =
          `Name: ${customerName || 'N/A'}`;
        document.getElementById('customerMobile').textContent =
          `Mobile: ${customerMobile || 'N/A'}`;
        document.getElementById('customerEmail').textContent =
          `Email: ${customerEmail || 'N/A'}`;

        // Populate Property and Payment Details
        document.getElementById('selectedProject').textContent =
          `Project: ${projectName}`;
        document.getElementById('selectedTower').textContent =
          `Tower: ${tower}`;
        document.getElementById('selectedProperty').textContent =
          `House/Unit No: ${propertyName}`;

        // Format and display payment amount
        const formattedAmount = parseFloat(paymentAmount).toLocaleString();
        document.getElementById('paymentAmount').textContent =
          `Amount to pay: ₹${formattedAmount}`;

        console.log("Payment summary populated successfully");

      } catch (error) {
        console.error("Error populating payment summary:", error);

        // Show fallback data in case of error
        document.getElementById('customerName').textContent = 'Name: Error loading data';
        document.getElementById('customerMobile').textContent = 'Mobile: Error loading data';
        document.getElementById('customerEmail').textContent = 'Email: Error loading data';
        document.getElementById('selectedProject').textContent = 'Project: Error loading data';
        document.getElementById('selectedTower').textContent = 'Tower: Error loading data';
        document.getElementById('selectedProperty').textContent = 'House/Unit No: Error loading data';
        document.getElementById('paymentAmount').textContent = `Amount to pay: ₹${paymentAmount}`;
      }
    }

    // Function to go back from summary to table
    function goBack() {
      document.getElementById("step4").classList.add("hidden");
      document.getElementById("step3").classList.remove("hidden");
    }

    // Function to go back to step1 from no booking found screen
    function goBackToStep1() {
      document.getElementById("noBookingFound").classList.add("hidden");
      document.getElementById("step1").classList.remove("hidden");

      // Clear previous input values and errors
      document.getElementById('phoneInput').value = '';
      document.getElementById('emailInput').value = '';
      hideError('phoneInput', 'phoneError');
      hideError('emailInput', 'emailError');
    }

    // Function to submit payment and redirect to Easebuzz
    async function submitPayment() {
      try {
        console.log("Initiating payment submission...");

        // Get selected booking and payment details
        const selectedRadio = document.querySelector('input[name="property"]:checked');
        const amountInput = document.getElementById('amountInput');

        if (!selectedRadio) {
          alert('Payment session expired. Please restart the process.');
          return;
        }

        // Get customer and booking details from radio button data attributes
        const customerName = selectedRadio.getAttribute('data-customer-name');
        const customerMobile = selectedRadio.getAttribute('data-customer-mobile');
        const customerEmail = selectedRadio.getAttribute('data-customer-email');
        const selectedBookingId = selectedRadio.getAttribute('data-booking-id');

        // Get booking details from table row
        const selectedRow = selectedRadio.closest('tr');
        const cells = selectedRow.querySelectorAll('td');

        const bookingName = cells[1] ? cells[1].textContent.trim() : '';
        const projectName = cells[2] ? cells[2].textContent.trim() : '';
        const tower = cells[3] ? cells[3].textContent.trim() : '';
        const unitType = cells[4] ? cells[4].textContent.trim() : '';
        const propertyName = cells[5] ? cells[5].textContent.trim() : '';

        if (!selectedBookingId || !customerName || !customerMobile) {
          alert('Booking details not found. Please restart the process.');
          return;
        }

        // Prepare payment data
        const paymentData = {
          action: 'createPaymentLink',
          bookingId: selectedBookingId,
          bookingName: bookingName,
          amount: parseFloat(amountInput.value),
          customerName: customerName,
          email: customerEmail,
          mobile: customerMobile,
          projectName: projectName,
          tower: tower,
          propertyName: propertyName,
          unitType: unitType
        };

        console.log("Payment data:", paymentData);

        // Show loading state
        const submitBtn = event.target;
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Processing...';
        submitBtn.disabled = true;

        // Call payment endpoint
        const response = await fetch('api_handler.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(paymentData)
        });

        if (!response.ok) {
          throw new Error(`Server error: ${response.status}`);
        }

        const result = await response.json();
        console.log('Payment response:', result);

        if (result.success && result.payment_url) {
          // Redirect to payment URL
          console.log('Redirecting to payment URL:', result.payment_url);
          window.location.href = result.payment_url;
        } else {
          // Show error message
          alert('Failed to create payment link: ' + (result.message || 'Unknown error'));

          // Reset button state
          submitBtn.textContent = originalText;
          submitBtn.disabled = false;
        }

      } catch (error) {
        console.error('Payment submission error:', error);
        alert('Failed to process payment. Please try again.');

        // Reset button state
        const submitBtn = event.target;
        submitBtn.textContent = 'Submit Payment';
        submitBtn.disabled = false;
      }
    }
  </script>
</body>

</html>