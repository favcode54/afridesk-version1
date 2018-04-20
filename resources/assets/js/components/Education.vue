<template>
    <div class="image">

        <h2>Education</h2>
        <div v-for="(educationList, index) in education" v-if="user_id == educationList.user_id" class="recipe__form">
            <div class="form__control"> {{educationList.institution_name}}</div>
            <div class="form__control"> {{educationList.degree}}</div>
            <div class="form__control"> {{educationList.course}}</div>
            <div class="form__control"> {{educationList.start_date}}</div>
            <div class="form__control"> {{educationList.end_date}}</div>
            <a @click="remove('education', index)" class="btn btn__danger">del</a>
            <a @click="edit(educationList)" href="#open-modal" class="btn btn__success">edit</a>
        </div>

        <div id="open-modal" class="modal-window">
            <div>
                <a href="#modal-close" title="Close" class="modal-close">Close</a>
                <h3>Edit Education</h3>
                <form v-on:submit="update(editEducation, editEducation.id, 'edit')">
                    <input type="hidden" class="form__control" v-model="editEducation.user_id">
                    <input type="text" class="form__control" v-model="editEducation.institution_name">
                    <input type="text" class="form__control " v-model="editEducation.degree">
                    <input type="text" class="form__control " v-model="editEducation.course">
                    <input type="date" class="form__control" v-model="editEducation.start_date">
                    <input type="date" class="form__control " v-model="editEducation.end_date">
                    <button class="btn">Save</button>
                </form>
            </div>
        </div>

        <div id="open-modal2" class="modal-window2">
            <div>
                <h3>New Education</h3>
                <form v-on:submit="addItem(newEducation)">
                    <a href="#modal-close2" title="Close" class="modal-close2">Close</a>
                    <input type="text" class="form__control" v-model="newEducation.institution_name">
                    <input type="text" class="form__control " v-model="newEducation.degree">
                    <input type="text" class="form__control " v-model="newEducation.course">
                    <input type="date" class="form__control" v-model="newEducation.start_date">
                    <input type="date" class="form__control " v-model="newEducation.end_date">
                    <button class="btn">Save</button>
                </form>
            </div>
        </div>

        <button class="btn">
            <a href="#open-modal2" class="btn btn__success">Add</a>
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
      storeURL: `/api/education`,
      action: "Viewall",
      education: [],
      editEducation: {
        institution_name: null,
        degree: null,
        course: null,
        start_date: null,
        end_date: null,
        user_id: null,
        id: null
      },
      newEducation: {
        institution_name: null,
        degree: null,
        course: null,
        start_date: null
      }
    };
  },
  mounted() {
    // this.educationData();
  },
  computed: {
    user_id() {
      if (this.authState.api_token) {
        return this.authState.user_id;
      }
    }
  },
  created() {
    this.getEducation();
  },

  methods: {
    getEducation() {
      get("/api/education").then(res => {
        this.education = res.data.education;
        console.log(this.education);
      });
    },
    update(form, id, mode) {
      event.preventDefault();
      let uri = `/api/education/${id}?_method=PUT`;
      const cForm = toMulipartedForm(form, mode);
      console.log(cForm);
      post(uri, cForm)
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
    },
    addItem(form) {
      form.user_id = this.authState.user_id;
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
    },

    save(form, mode) {
      if (mode == "create") {
        newEducation.user_id = this.authState.user_id;
        this.storeURL = `/api/education`;
      } else {
        // this.storeURL = `/api/education/${this.form.id}?_method=PUT`
      }
      const cForm = toMulipartedForm(form, mode);
      console.log(cForm);
      post(this.storeURL, cForm)
        .then(res => {
          if (res.data.saved) {
            Flash.setSuccess(res.data.message);
            this.$router.push(`/profile`);
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
      if (this.education.length > 0) {
        this.education.splice(index, 1);
      }
    },
    edit(educationData) {
      this.editEducation.institution_name = educationData.institution_name;
      this.editEducation.degree = educationData.degree;
      this.editEducation.course = educationData.course;
      this.editEducation.start_date = educationData.start_date;
      this.editEducation.end_date = educationData.end_date;
      this.editEducation.user_id = educationData.user_id;
      this.editEducation.id = educationData.id;
    }
  }
};
</script>
<style>
.modal-window,
.modal-window2 {
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

.modal-window:target,
.modal-window2:target {
  opacity: 1;
  pointer-events: auto;
}

.modal-window > div,
.modal-window2 > div {
  width: 400px;
  position: relative;
  margin: 10% auto;
  padding: 2rem;
  background: #fff;
  color: #444;
}

.modal-window2 header,
.modal-window header {
  font-weight: bold;
}

.modal-close,
.modal-close2 {
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

.modal-close:hover,
.modal-close2:hover {
  color: #000;
}

.modal-window h1,
.modal-window2 h1 {
  font-size: 150%;
  margin: 0 0 15px;
}
</style>