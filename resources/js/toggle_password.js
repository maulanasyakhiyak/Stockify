$(document).on('click','[data-toggle-eye]', function(){
    var target = $(this).data('toggle-eye');
    $(`[data-toggle-eye-icon='${target}']`).toggleClass('fa-eye');
    $(`[data-toggle-eye-icon='${target}']`).toggleClass('fa-eye-slash');
    const passwordInput = $(`#${target}`);
    const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
    passwordInput.attr('type', type);
});

/*
    **How to Use This Code:**

    1. **HTML Setup**:
       Make sure you have a password input element in your form, like this:
       ```html
       <div>
           <input type="password" name="toggle_eye" id="toggle_eye" />
           <button type="button" data-toggle="togglePassword" data-toggle-eye="toggle_eye">
               <i data-toggle="iconTogglePassword" class="fa-regular fa-eye"></i>
           </button>
       </div>
       ```
       - **`data-toggle-eye="toggle_eye"`**: This attribute should be on the button containing the eye icon. It refers to the ID of the password input (`new_password`) that you want to toggle the visibility of.
       - **`data-toggle="iconTogglePassword"`**: This attribute should be on the `<i>` element that contains the eye icon. The icon will toggle between the open eye (`fa-eye`) and closed eye (`fa-eye-slash`) depending on the password input visibility.

    2. **Integrate JavaScript**:
       - Make sure to add the JavaScript code just before the closing `</body>` tag or in a separate JS file linked to your page.
       - The script will automatically toggle the password visibility when you click the eye icon and switch the input type between `text` (to show the password) and `password` (to hide the password).
       
    3. **Font Awesome Icons**:
       - The eye icons used are Font Awesome icons (`fa-eye` for the open eye and `fa-eye-slash` for the closed eye). Make sure you've included Font Awesome in your project.

    By following these steps, you will be able to use the feature to show and hide passwords in your forms with the eye icon.
*/
