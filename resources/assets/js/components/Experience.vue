<template>
	<div class="image">
		<h2>Professional Experience</h2>
        <div v-for="(edulist, index) in experience" class="recipe__form">
            <div class="form__control"> {{edulist.compamy_name}}</div>
             <div class="form__control"> {{edulist.role_title}}</div>
             <div class="form__control"> {{edulist.city}}</div>
                <div class="form__control"> {{edulist.country}}</div>
               <div class="form__control"> {{edulist.description}}</div>
              <div class="form__control"> {{edulist.start_date}}</div>
               <div class="form__control"> {{edulist.end_date}}</div>
						
						<a @click="remove('experience', index)" class="btn btn__danger">del</a>
                        <a @click="edit(edulist)" href="#open-modal" class="btn btn__success">edit</a>
					</div>

                <div id="open-modal" class="modal-window">
                    <div><a href="#modal-close" title="Close" class="modal-close">Close</a>
     
                       <input type="text" class="form__control" v-model="editexperience.compamy_name">
						<input type="text" class="form__control " v-model="editexperience.role_title">
                        <input type="text" class="form__control " v-model="editexperience.city">
                        <input type="date" class="form__control" v-model="editexperience.country">
						<input type="date" class="form__control " v-model="editexperience.description"> 
                        <input type="date" class="form__control" v-model="editexperience.start_date">
						<input type="date" class="form__control " v-model="editexperience.end_date"> 
    
                    </div>
                </div>
					<button @click="addexperience" class="btn">Add experience</button>
	</div>
</template>
<script type="text/javascript">
export default {
  props: {
    value: {
      type: [String, File],
      default: null
    }
  },
  data() {
    return {
      experience: [],
      editexperience: {
        compamy_name: null,
        role_title: null,
        city: null,
        country: null,
        description: null,
        start_date: null,
        end_date: null
      }
    };
  },
  mounted() {
    this.Expdata();
  },
  methods: {
    Expdata() {
      this.experience = [
        {
          compamy_name: "Tesla",
          role_title: "Software Engineer",
          city: "California",
          country: "United State",
          description:
            " Set company technical vision and leading company’s technological development. Developed strategic plans and setting timelines for evaluation, development, and deployment of all technical, web, and mobile services. ",
          start_date: "09,2008",
          end_date: "03,2014"
        }
      ];
    },
    addexperience() {
      this.experience.push({
        compamy_name: "",
        role_title: "",
        city: "",
        country: "",
        description: "",
        start_date: "",
        end_date: ""
      });
    },
    remove(type, index) {
      if (this.experience.length > 0) {
        this.experience.splice(index, 1);
      }
    },
    edit(Expdata) {
      this.editexperience.compamy_name = Expdata.compamy_name;
      this.editexperience.role_title = Expdata.role_title;
      this.editexperience.city = Expdata.city;
      this.editexperience.country = Expdata.country;
      this.editexperience.description = Expdata.description;
      this.editexperience.start_date = Expdata.start_date;
      this.editexperience.end_date = Expdata.end_date;
    }
  }
};
</script>
<style>
.modal-window {
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

.modal-window:target {
  opacity: 1;
  pointer-events: auto;
}

.modal-window > div {
  width: 400px;
  position: relative;
  margin: 10% auto;
  padding: 2rem;
  background: #fff;
  color: #444;
}

.modal-window header {
  font-weight: bold;
}

.modal-close {
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

.modal-close:hover {
  color: #000;
}

.modal-window h1 {
  font-size: 150%;
  margin: 0 0 15px;
}
</style>
