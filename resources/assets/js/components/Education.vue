<template>
	<div class="image">
		<h2>Education</h2>
         <div v-for="(edulist, index) in education" class="recipe__form">
            <div class="form__control"> {{edulist.school}}</div>
             <div class="form__control"> {{edulist.degree}}</div>
             <div class="form__control"> {{edulist.course}}</div>
              <div class="form__control"> {{edulist.start}}</div>
               <div class="form__control"> {{edulist.end}}</div>
						
						<a @click="remove('education', index)" class="btn btn__danger">del</a>
                        <a @click="edit(edulist)" href="#open-modal" class="btn btn__success">edit</a>
					</div>

                <div id="open-modal" class="modal-window">
                    <div><a href="#modal-close" title="Close" class="modal-close">Close</a>
     
                       <input type="text" class="form__control" v-model="editeducation.school">
						<input type="text" class="form__control " v-model="editeducation.degree">
                        <input type="text" class="form__control " v-model="editeducation.course">
                        <input type="date" class="form__control" v-model="editeducation.start">
						<input type="date" class="form__control " v-model="editeducation.end"> 
    
                    </div>
                </div>
					<button @click="addEducation" class="btn">Add Education</button>
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
      education: [],
      editeducation:{
          school:null,
          degree:null,
           course:null,
          start:null,
          end:null
      },
    };
  },
  mounted() {
    this.Edudata();
  },
  methods: {
    Edudata() {
      this.education = [
        {
          school: "Federal University of Technology",
          degree: "Mtech",
          course:'Electrical & Electronics Engineering',
          start: "09,2008",
          end: "03,2014"
        },
        {
          school: "Ladoke Akintola University",
          degree: "  BEng",
          course:'Electrical & Electronics Engineering',
          start: "09,2008",
          end: "03,2014"
        },
        {
          school: "Babcock University",
          degree: "Mtech",
          course:'Electrical & Electronics Engineering',
          start: "09,2008",
          end: "03,2014"
        }
      ];
    },
    addEducation() {
      this.education.push({
        school: "",
        degree: "",
        course: "",
        start: "",
        end: ""
      });
    },
    remove(type, index) {
      if (this.education.length > 0) {
        this.education.splice(index, 1);
      }
    },
    edit(edudata) {
       this.editeducation.school = edudata.school;
       this.editeducation.degree = edudata.degree;
        this.editeducation.degree = edudata.course;
       this.editeducation.start = edudata.start;
       this.editeducation.end = edudata.end;
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
