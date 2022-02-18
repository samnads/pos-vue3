<template>
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-8 col-lg-7 col-xl-6">
          <img
            src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
            class="img-fluid"
            alt="Phone image"
          />
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
          <form>
            <!-- Email input -->
            <div class="form-floating mb-3">
  <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
  <label for="floatingInput">Email address</label>
</div>
            <!-- Password input -->
           <div class="form-floating">
  <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
  <label for="floatingPassword">Password</label>
</div>

            <div class="d-flex justify-content-around align-items-center mb-4">
              <!-- Checkbox -->
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  value=""
                  id="form1Example3"
                  checked
                />
                <label class="form-check-label" for="form1Example3">
                  Remember me
                </label>
              </div>
              <a href="#!">Forgot password?</a>
            </div>

            <!-- Submit button -->
           <div class="d-grid gap-2">
  <button class="btn btn-primary" type="button">Login</button>
</div>

            <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
            </div>
            <div class="d-grid gap-2">
  <button class="btn btn-primary btn-lg btn-block"  style="background-color: #3b5998" type="button"><i class="fab fa-facebook-f me-2"></i>Continue with Facebook</button>
  <button class="btn btn-primary btn-lg btn-block" type="button"> <i class="fab fa-twitter me-2"></i>Continue with Twitter</button>
</div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>
<style>
.divider:after,
.divider:before {
  content: "";
  flex: 1;
  height: 1px;
  background: #eee;
}
</style>
