<template>
    <div class="not__found" v-if="cauth || checkauth">
		<h1>Welcome Home</h1>
	</div>
</template>
<script type="text/javascript">
import Auth from "../../store/auth";
import Flash from "../../helpers/flash";
import { post } from "../../helpers/api";
export default {
  data() {
    return {
      checkauth: false,
      authState: Auth.state,
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
      if (!this.authState.api_token) {
        this.checkauth = true;
        return true;
      }
      return true;
    }
  },
  watch: {
    checkauth: function() {
      this.checkauth1();
      console.log("call change");
    }
  },
  methods: {
    checkauth1() {
      this.$router.push("/");
      console.log("call redirect");
    }
  }
};
</script>