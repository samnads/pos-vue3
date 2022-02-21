<template>
  <section class="">
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
          <form @submit.prevent="submitForm">
            <!-- Email input -->
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control"
                id="floatingInput"
                placeholder="name@example.com"
                v-model="username"
              />
              <label for="floatingInput">Email address</label>
            </div>
            <!-- Password input -->
            <div class="form-floating">
              <input
                type="password"
                class="form-control"
                id="floatingPassword"
                placeholder="Password"
                v-model="password"
              />
              <label for="floatingPassword">Password</label>
            </div>

            <div
              class="d-flex justify-content-around align-items-center mb-4 mt-4"
            >
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
              <router-link to="/admin/login">Forgot password?</router-link>
            </div>

            <!-- Submit button -->
            <div class="d-grid gap-2">
              <button class="btn btn-primary" type="submit" value="Submit">
                Login
              </button>
            </div>

            <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
            </div>
            <div class="d-grid gap-2">
              <button
                class="btn btn-primary btn-lg btn-block"
                style="background-color: #3b5998"
                type="button"
              >
                <i class="bi bi-facebook"></i>&nbsp;Continue with Facebook
              </button>
              <button class="btn btn-primary btn-lg btn-block" type="button">
                <i class="bi bi-twitter"></i>&nbsp;Continue with Twitter
              </button>
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
a {
  text-decoration: none !important;
}
</style>
<script>
export default {
  data() {
    return {
      username: "",
      email: "",
      password: "",
    };
  },
  methods: {
    // submit the form to our backend api
    submitForm() {
      const self = this;
      const formData = {
        action: "login",
        data: { username: this.username, password: this.password },
      };
      this.axios
        .post("http://localhost/CyberLikes-POS/admin/ajax/login", formData)
        .then(function (response) {
          let data = response.data;
          if (data.success == true) {
            console.log(data.message);
            self.$router.push({ name: "adminDashboard" }).catch(() => {});
          } else {
            alert(data.message);
          }
        })
        .catch((error) => {
          this.errorMessage = error.message;
          alert("There was an error! " + error);
        });
    },
  },
};
</script>