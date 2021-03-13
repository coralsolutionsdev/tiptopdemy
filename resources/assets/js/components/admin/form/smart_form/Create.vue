<template>
  <div>
    <div class="add-group-wrapper">
      <button @click="addNewGroup()" class="uk-button uk-button-secondary" uk-tooltip="Add new group"><span uk-icon="icon: plus; ratio: 1.5"></span>
      </button>
    </div>
    <div class="uk-grid-small uk-child-width-1-1@s" uk-grid>
      <div v-for="(group, key) in groups">
        <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-secondary-bg">

          <div class="uk-grid-collapse uk-text-center" uk-grid>
            <div class="uk-width-auto">
              <span class="uk-sortable-handle" uk-icon="icon: table"></span> <span class="form-item-title uk-margin-small-left"><span v-html="key+1"></span> | Group questions</span>
            </div>
            <div class="uk-width-expand">
            </div>
            <div class="uk-width-auto">
              <span @click="openGroupSettings(key, group)" style="margin: 0 10px" class="open-config hover-primary" uk-icon="icon: cog" href="" uk-tooltip="Settings"></span>
              <span @click="deleteGroup(group)" style="margin: 0 10px" class="hover-danger remove-form-item" uk-icon="icon: trash" uk-tooltip="Delete"></span>
            </div>
          </div>
          <div class="uk-margin">
            <div class="uk-background-secondary uk-light group-title">
              <span class="" v-html="group.title"></span>
            </div>
            <div class="bg-white uk-padding-small">
              <div class="group-preview" v-if="!group.editMode">
                <p class="uk-margin-remove" v-html="group.description"></p>
              </div>
              <div class="group-settings" :class="{ 'height-0':!group.editMode }">
                <div class="uk-margin-small">
                  <label class="uk-form-label h-header">Section title</label>
                  <div class="uk-form-controls">
                    <input type="text" class="uk-input uk-form-small input-title" placeholder="Section title" v-model="group.title">
                  </div>
                </div>
                <div class="uk-margin-small">
                  <label class="uk-form-label h-header">Section description</label>
                  <div class="uk-grid-collapse" uk-grid>
                    <div class="uk-width-expand@m">
                      <div class="title-section">
                        <input type="hidden" class="hidden-input-title">
                        <textarea class="uk-textarea input-description" :class="'content-editor-'+key" rows="12" placeholder="type your description here" v-model="group.description"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="uk-margin-small">
                  <label class="uk-form-label h-header">Questions settings</label>
                  <div class="uk-grid-small" uk-grid>
                    <div class="uk-width-5-5@s uk-flex uk-flex-middle">
                      <label><input class="uk-checkbox input-shuffle-questions" type="checkbox"> <span style="margin: 0 0.5em">Shuffle Questions</span></label>
                    </div>
                  </div>
                  <div class="uk-margin uk-grid-small score-section" uk-grid>
                    <div class="uk-width-1-5@m uk-flex uk-flex-middle">
                      <label>Questions number allowed to answer:</label>
                    </div>
                    <div class="uk-width-expand@m ">
                      <input type="number" class="uk-input uk-form-small input-section-allowed-number" placeholder="5">
                    </div>
                  </div>
                  <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                    <label>Evaluation:</label>
                    <label><input class="uk-radio input-evaluation-auto" type="radio" name="radio1" value="" checked>  Auto  </label>
                    <label><input class="uk-radio input-evaluation-manual" type="radio" name="radio1" value="">  Manual  </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!--Questions-->
          <div>
            <div class="group-question" v-for="(question, questionKey) in group.items">
              <div class="uk-padding-small bg-white">
                <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                  <div class="uk-width-1-4">
                    <span uk-icon="icon: table"></span> <span v-html="questionKey+1"></span> | Question Item
                  </div>
                  <div class="uk-width-expand">
                    <select class="uk-select uk-form-small">
                      <option>Available questions</option>
                      <option>Question title 01</option>
                      <option>Question title 02</option>
                    </select>
                  </div>
                  <div class="uk-width-1-4">
                    <div class="uk-grid-small  uk-flex uk-flex-middle" uk-grid>
                      <div class="uk-width-expand">
                        Me.
                      </div>
                      <div class="uk-width-expand">
                        Fixed
                      </div>
                      <div class="uk-width-auto">
                        Qs. count (2)
                      </div>
                      <div class="uk-width-expand uk-text-right">
                        <span @click="deleteGroupItem(group, questionKey)" class="hover-danger remove-form-item" uk-icon="icon: trash" uk-tooltip="Delete"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                  <div class="uk-width-1-4">
                    <div class="uk-grid-small" uk-grid>
                      <div class="uk-width-1-2">
                        <input class="uk-input uk-form-small" type="text" @keypress="onlyNumber" placeholder="Unit no." v-model="question.unit_num" :class="{'uk-form-success': question.unit_num && question.unit_num <=  currentUnitNum, 'uk-form-danger': question.unit_num && question.unit_num > currentUnitNum}">
                      </div>
                      <div class="uk-width-1-2">
                        <input class="uk-input uk-form-small" type="text" @keypress="onlyNumber" placeholder="Lesson no." v-model="question.lesson_num" :class="{'uk-form-success': question.lesson_num && question.lesson_num <=  currentLessonNum, 'uk-form-danger': question.lesson_num && question.lesson_num > currentLessonNum}">
                      </div>
                    </div>
                  </div>
                  <div class="uk-width-1-4">
                    <div class="uk-grid-small" uk-grid>
                      <div class="uk-width-1-2">
                        <select class="uk-select uk-form-small">
                          <option>Got from</option>
                          <option>Quoted</option>
                          <option>Modified</option>
                          <option>Out of Box</option>
                        </select>
                      </div>
                      <div class="uk-width-1-2">
                        <select class="uk-select uk-form-small">
                          <option>Bloom TAX</option>
                          <option>Remember</option>
                          <option>Understanding</option>
                          <option>Applying</option>
                          <option>Analyzing</option>
                          <option>Evaluating</option>
                          <option>Creating</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="uk-width-1-4">
                    <div class="uk-grid-small" uk-grid>
                      <div class="uk-width-1-2">
                        <input class="uk-input uk-form-small" type="text" placeholder="Tax-2" disabled >
                      </div>
                      <div class="uk-width-1-2">
                        <select class="uk-select uk-form-small">
                          <option>Difficulty</option>
                          <option>Very easy</option>
                          <option>Easy</option>
                          <option>Moderate</option>
                          <option>Hard</option>
                          <option>Very hard</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="uk-width-expand">
                    <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                      <div class="uk-width-expand">
                        <label><input class="uk-checkbox" type="checkbox"></label>
                      </div>
                      <div class="uk-width-expand">
                        <label><input class="uk-radio" type="radio" name="radio2"></label>
                      </div>
                      <div class="uk-width-auto">
                        <button class="uk-button uk-button-primary uk-button-small" @click="runQuestionFilters(question)">Run</button>
                      </div>
                      <div class="uk-width-expand uk-text-right">
                        <span @click="addNewGroupQuestion(group)" class="hover-primary" uk-tooltip="title: Add new question"><span uk-icon="plus-circle"></span></span>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>

        </div>
      </div>
      <div v-if="groups.length == 0" class="uk-text-center uk-padding">
        <img class="gray-folder" data-src="/storage/assets/file_icons/folder.png" width="90" alt="" uk-img>
        <p class="uk-text-muted" v-html="'There is no available groups yet, click on the + icon to add new group'"></p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Create",
  data(){
    return{
      currentUnitNum:1,
      currentLessonNum:4,
      groups: [
        {
          title: 'Group A',
          description: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',
          editMode:false,
          items:[
            {
              id:1,
              unit_num:null,
              unit_status:true,
              lesson_num:null,
              lesson_status:true,
              source:0,
            },
          ],

        },
      ],

    }
  },
  created() {
  },
  methods:{
    openGroupSettings(key, group){
      group.editMode = !group.editMode;
      addMinyTinyEditor('.content-editor-'+key);

    },
    addNewGroupQuestion(group){
      group.items.push(
          {
            id:1,
            unit_num:null,
            unit_status:true,
            lesson_num:null,
            lesson_status:true,
            source:0,
          }
      );
    },
    addNewGroup(){
      var newGroupItem = {
        title: 'Group A',
        description: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',
        editMode:false,
        items:[
          {
            id:1,
            unit_num:null,
            unit_status:true,
            lesson_num:null,
            lesson_status:true,
            source:0,
          },
        ],
      };
      console.log(this.groups);
      this.groups.push(newGroupItem);
      this.scrollToEndOfPage();
      console.log(this.groups);

    },
    runQuestionFilters(question){
      alert('هذا بروتوتايب فقط, ميجيب نتائج 😆 ')
    },
    deleteGroup(group){
      var groupKey = this.groups.indexOf(group);
      this.groups.splice(groupKey, 1);

    },
    deleteGroupItem(group, questionKey){
      var itemsCount = group.items.length;
      if (itemsCount === 1){
        this.$Notify({
          title: 'Oops! something going wrong',
          message: 'Group should have at least one question item',
          type: 'error',
          duration: 4000
        });

      } else {
        group.items.splice(questionKey, 1);
      }

    },
    scrollToEndOfPage(){
      $('body, html').animate({
        scrollTop: $('.add-group-wrapper').offset().top
      }, 300);
    },
    onlyNumber ($event) {
      //console.log($event.keyCode); //keyCodes value
      let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
      if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
        $event.preventDefault();
      }
    },
  }
}
</script>

<style scoped>
.group-title{
  display: inline-flex;
  padding: 5px 15px;
  border-radius: 5px 5px 0 0;
}
.height-0{
  height: 0px !important;
  overflow: hidden;
}
.question-items td {
   padding: 0px 12px !important;
  /*vertical-align: top;*/
}
.question-items th {
  padding: 10px 12px;
}
.group-question{
  margin-bottom: 10px;
}
.question-filter{
  padding: 0px 15px;
}
.question-filter .uk-form-label {
   color: #999999;
   font-size: 14px;
}
.add-group-wrapper{
  position:fixed;
  bottom: 35px;
  right: 35px;
  z-index: 20 !important;

}
.add-group-wrapper button{
  border-radius: 50%;
  padding: 5px 10px;
}
.gray-folder{
  opacity: 0.3;
  filter: grayscale(90%);
}
</style>