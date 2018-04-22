<template>
    <div class="image">

        <h2>Professional Experience</h2>
        <div v-for="(experienceList, index) in experience" class="favcode__form">
            <div class="form__control"> {{experienceList.compamy_name}}</div>
            <div class="form__control"> {{experienceList.role_title}}</div>
            <div class="form__control"> {{experienceList.city}}</div>
            <div class="form__control"> {{experienceList.country}}</div>
            <div class="form__control"> {{experienceList.description}}</div>
            <div class="form__control"> {{experienceList.start_date}}</div>
            <div class="form__control"> {{experienceList.end_date}}</div>
            <a @click="remove('experience', index)" class="btn btn__danger">del</a>
            <a @click="edit(experienceList)" href="#open-modal3" class="btn btn__success">edit</a>
        </div>

        <div id="open-modal3" class="modal-window3">
            <div>
                <a href="#modal-close3" title="Close" class="modal-close3">Close</a>
                <h3>Edit experience</h3>
                <form v-on:submit="update(editExperience, editExperience.id, 'edit')">
                    <input type="hidden" class="form__control" v-model="editExperience.user_id">
                    <input type="text" class="form__control" v-model="editExperience.compamy_name">
                    <input type="text" class="form__control " v-model="editExperience.role_title">
                    <input type="text" class="form__control " v-model="editExperience.city">
                    <input type="text" class="form__control" v-model="editExperience.country">
                    <input type="text" class="form__control " v-model="editExperience.description">
                    <input type="date" class="form__control" v-model="editExperience.start_date">
                    <input type="date" class="form__control " v-model="editExperience.end_date">
                    <button class="btn">Save</button>
                </form>
            </div>
        </div>

        <div id="open-modal4" class="modal-window4">
            <div>
                <h3>New experience</h3>
                <form v-on:submit="addExperience(newExperience)">
                    <a href="#modal-close4" title="Close" class="modal-close4">Close</a>
                    <input type="text" placeholder="Company" class="form__control" v-model="newExperience.compamy_name">
                    <input type="text" placeholder="Job Role" class="form__control " v-model="newExperience.role_title">
                    <input type="text" placeholder="City" class="form__control " v-model="newExperience.city">
                     <input type="text" placeholder="Country" class="form__control" v-model="newExperience.country">
                    <input type="text" placeholder="Description" class="form__control " v-model="newExperience.description">
                    <input type="date" placeholder="Start date" class="form__control" v-model="newExperience.start_date">
                    <input type="date" placeholder="End date" class="form__control " v-model="newExperience.end_date">
                    <button class="btn">Save</button>
                </form>
            </div>
        </div>

        <button class="btn">
            <a href="#open-modal4" class="btn btn__success">Add</a>
        </button>

    </div>
</template>
<script type="text/javascript">
import Vue from "vue";
import Auth from "../store/auth";
import axios from "axios";
import Flash from "../helpers/flash";
import { get, post, update } from "../helpers/api";
import { toMulipartedForm } from "../helpers/form";
export default {
  props: {
    value: {
      type: [String, File],
      default: null
    }
  },
  data() {
    return {
      authState: Auth.state,
      storeURL: `/api/experience`,
      action: "Viewall",
      experience: [],
      editExperience: {
        compamy_name: null,
        role_title: null,
        city: null,
        start_date: null,
        end_date: null,
        user_id: null,
        id: null
      },
      newExperience: {
        compamy_name: null,
        role_title: null,
        city: null,
        start_date: null
      }
    };
  },
  mounted() {
    // this.experienceData();
  },
  computed: {
    user_id() {
      if (this.authState.api_token) {
        return this.authState.user_id;
      }
    }
  },
  created() {
    this.getExperience();
  },

  methods: {
    getExperience() {
      get("/api/experience").then(res => {
        this.experience = res.data.experience;
        console.log(this.experience);
      });
    },
    update(form, id, mode) {
      event.preventDefault();
      let uri = `/api/experience/${id}?_method=PUT`;
      const cForm = toMulipartedForm(form, mode);
      console.log(cForm);
      post(uri, cForm)
        .then(res => {
          if (res.data.saved) {
            Flash.setSuccess(res.data.message);
            this.getExperience();
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
    addExperience(form) {
      form.user_id = this.authState.user_id;
      console.log(form);
      event.preventDefault();

      post(this.storeURL, form)
        .then(res => {
          if (res.data.saved) {
            Flash.setSuccess(res.data.message);
            this.getExperience();
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

    remove(type, index) {
      if (this.experience.length > 0) {
        this.experience.splice(index, 1);
      }
    },
    edit(experienceData) {
      this.editExperience.compamy_name = experienceData.compamy_name;
      this.editExperience.role_title = experienceData.role_title;
      this.editExperience.city = experienceData.city;
      this.editExperience.country = experienceData.country;
      this.editExperience.description = experienceData.description;
      this.editExperience.start_date = experienceData.start_date;
      this.editExperience.end_date = experienceData.end_date;
      this.editExperience.user_id = experienceData.user_id;
      this.editExperience.id = experienceData.id;
    }
  }
};
</script>
<style>
.modal-window4,
.modal-window3 {
  position: fixed;
  background-color: rgba(255, 255, 255, 0.15);
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 999;
  opacity: 0;
  pointer-events: none;
  -webkit-transition: all 0.3s;
  -moz-transition: all 0.3s;
  transition: all 0.3s;
}

.modal-window3:target,
.modal-window4:target {
  opacity: 1;
  pointer-events: auto;
}

.modal-window3 > div,
.modal-window4 > div {
  width: 400px;
  position: relative;
  margin: 10% auto;
  padding: 2rem;
  background: #fff;
  color: #444;
}

.modal-window3 header,
.modal-window4 header {
  font-weight: bold;
}

.modal-close3,
.modal-close4 {
  color: #aaa;
  line-height: 50px;
  font-size: 80%;
  position: absolute;
  right: 0;
  text-align: center;
  top: 0;
  width: 70px;
  text-decoration: none;
}

.modal-close3:hover,
.modal-close4:hover {
  color: #000;
}

.modal-window3 h1,
.modal-window4 h1 {
  font-size: 150%;
  margin: 0 0 15px;
}
</style>