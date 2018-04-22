<template>
    <form class="form" @submit.prevent="register" v-if="cauth || checkauth">
        <h1 class="form__title">Create an Account</h1>
        <div class="form__group">
            <label>First Name</label>
            <input type="text" class="form__control" v-model="form.first_name">
            <small class="error__control" v-if="error.name">{{error.first_name[0]}}</small>
        </div>
        <div class="form__group">
            <label>Last Name</label>
            <input type="text" class="form__control" v-model="form.last_name">
            <small class="error__control" v-if="error.name">{{error.last_name[0]}}</small>
        </div>
        <div class="form__group">
            <label>Email</label>
            <input type="text" class="form__control" v-model="form.email">
            <small class="error__control" v-if="error.email">{{error.email[0]}}</small>
        </div>
        <div class="form__group">
            <label>Password</label>
            <input type="password" class="form__control" v-model="form.password">
            <small class="error__control" v-if="error.password">{{error.password[0]}}</small>
        </div>
        <div class="form__group">
            <label>Confirm Password</label>
            <input type="password" class="form__control" v-model="form.password_confirmation">
        </div>
        <div class="form__group">
            <button :disabled="isProcessing" class="btn btn__primary">Register</button>
        </div>
    </form>
</template>
<script type="text/javascript">
import Auth from "../../store/auth";
import Flash from "../../helpers/flash";
import { post } from "../../helpers/api";
export default {
  data() {
    return {
      authState: Auth.state,
      checkauth:false,
      form: {
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        password_confirmation: ""
      },
      error: {},
      isProcessing: false
    };
  },
  computed: {
      cauth() {
      if (this.authState.api_token) {
    this.checkauth = true
        return true;
      }
      return true;
    },
   
  },
  watch: {
   checkauth:function () {
    this.checkauth1();
    console.log('call change')
    }
},
  methods: {
    checkauth1() {
        this.$router.push("/home");
        console.log('call redirect')
    },
    register() {
      this.isProcessing = true;
      this.error = {};
      post("api/register", this.form)
        .then(res => {
          if (res.data.registered) {
            Flash.setSuccess(
              "Congratulations! You have now successfully registered."
            );
            // this.$router.push('/home')
            // this.login();
            this.resetForm();
            
          }
          this.isProcessing = false;
        })
        .catch(err => {
          if (err.response.status === 422) {
            this.error = err.response.data;
          }
          this.isProcessing = false;
        });
    },
    login() {
      this.error = {};
      post("api/login", this.form)
        .then(res => {
          if (res.data.authenticated) {
            // set token
            Auth.set(res.data.api_token, res.data.user_id);
            Flash.setSuccess("You have successfully logged in.");
            this.$router.push("/home");
          }
        })
        .catch(err => {
          if (err.response.status === 422) {
            this.error = err.response.data;
          }
        });
    },
    resetForm(){
         this.form.first_name = '';
         this.form.last_name= '';
         this.form.email= '';
         this.form.password= '';
         this.form.password_confirmation= '';
      }
  }
};
</script>