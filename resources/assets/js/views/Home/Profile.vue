<template>
    <div class="not__found" v-if="cauth || checkauth">
		<h1>Profile Dashboard</h1>
   
    <div class="card" v-if="!showeditmodal">
  
   <img :src="`/images/${profile.image}`" v-if="profile.image">
   <img :src="`/images/fav.jpg`" v-else>
  
  <h1>Favour Ori</h1>
  <p class="title">CEO & Founder, Favcode</p>
  <p>Harvard University</p>
<button @click="showeditmodal = true">edit/upload</button>

</div>
<div v-if="showeditmodal" class="card ">
  <button @click="showeditmodal = false">cancle</button>
  <div class="recipe__image">
				<div class="recipe__box">
					<image-upload v-model="form.image"></image-upload>
				<small class="error__control" v-if="error.image">{{error.image[0]}}</small> 
				</div>
			</div>
      <button  v-if="profile.image" class="btn btn__primary" @click="uploadImage('img','update')" :disabled="isProcessing">Save</button> 
      <button v-else class="btn btn__primary" @click="uploadImage('img','upload')" :disabled="isProcessing">Save</button> 
</div>
  
<education></education>
<experience></experience>

	</div>
</template>
<script type="text/javascript">
import Vue from "vue";
import { get, post, update } from "../../helpers/api";
import ImageUpload from "../../components/ProfilePicUpload.vue";
import Education from "../../components/Education.vue";
import Experience from "../../components/Experience.vue";
import Auth from "../../store/auth";
import Flash from "../../helpers/flash";
export default {
  components: {
			ImageUpload,
      Education,
      Experience
		},
  data() {
    return {
      mode1:'upload',
      showeditmodal: false,
      checkauth: false,
      authState: Auth.state,
      profile: [],
      form:{},
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
  created() {
    this.getImage();
  },
  methods: {
    checkauth1() {
      this.$router.push("/");
      console.log("call redirect");
    },
    getImage(){
 get("/api/profile").then(res => {
        this.profile = res.data.profile;
        console.log(this.profile);
      });
    },
    uploadImage(mode, action){
      form.user_id = this.authState.user_id;
       var uri
      if (action === 'upload'){
  uri = `/api/profile`; 
      }
     else{
       uri = `/api/profile/${id}?_method=PUT`; 
     }
      
      const cForm = toMulipartedForm(form, mode);
      console.log(cForm);
      console.log(form);
      event.preventDefault();

      post(this.storeURL, form)
        .then(res => {
          if (res.data.saved) {
            Flash.setSuccess(res.data.message);
            this.getEducation();
          }
          this.isProcessing = false;
        })
        .catch(err => {
          if (err.response.status === 422) {
            this.error = err.response.data;
          }
          this.isProcessing = false;
        });
    }
    
  }
};
</script>
<style>
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
}

.title {
  color: grey;
  font-size: 18px;
}

button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

a {
  text-decoration: none;
  font-size: 22px;
  color: black;
}

button:hover,
a:hover {
  opacity: 0.7;
}
</style>