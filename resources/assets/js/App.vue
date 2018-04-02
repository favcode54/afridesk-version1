<template>
    <div class="container">
        <div class="navbar">
            <div class="navbar__brand">
                <!-- <router-link to="/">Afridesk</router-link> -->
                Afridesk
            </div>
            <ul class="navbar__list">
                <li class="navbar__item" v-if="auth">
                    {{ username }}
                    <span class="caret"></span>
                </li>
                <li class="navbar__item" v-if="auth">
                    <a @click.stop="logout">LOGOUT</a>
                </li>
            </ul>

            <form v-if="guest" class="navbar__loginn navbar__form navbar__right" @submit.prevent="login">
                <div class="navbar__item">
                    <input type="text" class="form__control" placeholder="Email" v-model="forml.email">
                    <small class="error__control" v-if="error.email">{{error.email[0]}}</small>
                </div>
                <div class="navbar__item">
                    <input type="password" class="form__control" placeholder="Password" v-model="forml.password">
                    <small class="error__control" v-if="error.password">{{error.password[0]}}</small>
                </div>
                <div class="navbar__item">
                    <button :disabled="isProcessing" class="btn btn__primary">Login</button>
                </div>
            </form>

        </div>
        <div class="flash flash__error" v-if="flash.error">
            {{flash.error}}
        </div>
        <div class="flash flash__success" v-if="flash.success">
            {{flash.success}}
        </div>
        <router-view></router-view>
    </div>
</template>
<script type="text/javascript">
import Auth from "./store/auth";
import Flash from "./helpers/flash";
import { post, interceptors } from "./helpers/api";
export default {
  created() {
    // global error http handler
    interceptors(err => {
      if (err.response.status === 401) {
        Auth.remove();
        this.$router.push("/");
      }
      if (err.response.status === 500) {
        Flash.setError(err.response.statusText);
      }
      if (err.response.status === 404) {
        this.$router.push("/not-found");
      }
    });
    Auth.initialize();
  },
  data() {
    return {
      authState: Auth.state,
      flash: Flash.state,

      forml: {
        email: "",
        password: ""
      },

      error: {},
      isProcessing: false
    };
  },
  computed: {
	  username(){
 if (this.authState.api_token) {
        return this.authState.username;
      }
	  },
    auth() {
      if (this.authState.api_token) {
        console.log(this.authState.api_token);
        return true;
      }
      return false;
    },
    guest() {
      return !this.auth;
    }
  },
  methods: {
    login() {
      this.isProcessing = true;
      this.error = {};
      post("api/login", this.forml)
        .then(res => {
          if (res.data.authenticated) {
            // set token
            Auth.set(res.data.api_token, res.data.user_id, res.data.username);
            Flash.setSuccess("You have successfully logged in.");
            this.$router.push("/home");
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
    logout() {
      post("/api/logout").then(res => {
        if (res.data.done) {
          // remove token
          Auth.remove();
          Flash.setSuccess("You have successfully logged out.");
          this.$router.push("/");
        }
      });
    }
  }
};
</script>