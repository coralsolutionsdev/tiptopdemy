<template>
  <div>

    <div class="add-group-wrapper">
      <button @click="addNewGroup()" class="uk-button uk-button-secondary" uk-tooltip="Add new group"><span uk-icon="icon: plus; ratio: 1.5"></span>
      </button>
    </div>



    <div class="uk-grid-small uk-child-width-1-1@s" uk-grid>
      <div>
        <div class="uk-card uk-card-default uk-card-body uk-padding-small">
          <div class="uk-grid-small uk-text-center" uk-grid>
            <div class="uk-width-auto">
              <span class="uk-button uk-button-default" style="padding: 0 20px" @click="settingTab = !settingTab" :uk-tooltip="$t('main.General settings')"><span uk-icon="icon: settings"></span></span>
            </div>
            <div class="uk-width-expand">
            </div>
            <div class="uk-width-auto">
              <span @click="generateForm()" class="uk-button uk-button-primary uk-align-right submit-form">
                <span v-if="!generatingMode" v-html="$t('main.Generate')"></span>
                <span v-else><span uk-spinner="ratio: 0.8"></span></span>
              </span>
            </div>
          </div>
        </div>
      </div>

      <div :class="{'h-0': !showForms}">
        <div class="uk-card uk-card-default uk-card-body uk-padding-small">
          <div>
            <table class="uk-table uk-table-divider">
              <thead>
              <tr>
                <th class="uk-table-expand">Quiz info</th>
                <th class="uk-width-small uk-text-center">Items count</th>
                <th class="uk-width-small">Edit form</th>
              </tr>
              </thead>
              <tbody>
              <tr v-if="forms.length > 0" v-for="form in forms">
                <td v-html="form.title"></td>
                <td class="uk-text-center" v-html="form.count"></td>
                <td class="uk-text-right"><a :href="form.edit_url" target="_blank" class="uk-button uk-button-primary uk-button-small"><span class="uk-margin-small-right" uk-icon="icon: pencil"></span> Edit</a></td>
              </tr>
              <tr v-if="forms.length === 0">
                <td colspan="2" class="uk-text-center">No items available yet.</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div :class="{'h-0':!settingTab}">
        <div class="uk-card uk-card-default uk-card-body uk-padding-small">
          <div uk-grid>
            <div class="uk-width-auto@m">
              <ul class="uk-tab-left" uk-tab="connect: #settingTabs; animation: uk-animation-fade">
                <li><a href="#">General info</a></li>
                <li><a href="#">Scoping</a></li>
                <li><a href="#">Properties</a></li>
                <li><a href="#">Others</a></li>
              </ul>
            </div>
            <div class="uk-width-expand@m">
              <ul id="settingTabs" class="uk-switcher">
                <li>
                  <div class="h-header">Quiz information</div>
                  <div class="row uk-margin-small">
                    <div class="col-1 uk-flex uk-flex-middle">
                      <span v-html="$t('main.Title')"></span>:
                    </div>
                    <div class="col-11">
                      <input class="uk-input uk-form-small" v-model="settings.title" type="text">
                    </div>
                  </div>
                  <div class="row uk-margin-small" uk-grid>
                    <div class="col-1 uk-flex uk-flex-middle">
                      <span v-html="$t('main.Description')"></span>:
                    </div>
                    <div class="col-11">
                      <textarea class="uk-textarea content-editor" v-model="settings.description" rows="25" placeholder="Add quiz description here"></textarea>
                    </div>
                  </div>
                  <div class="row uk-margin-small" uk-grid>
                    <div class="col-3">
                      status
                    </div>
                  </div>
                  <div class="row uk-margin-small" uk-grid>
                    <div class="col-1 uk-flex uk-flex-middle">
                      <span v-html="$t('main.Position')"></span>:
                    </div>
                    <div class="col-3">
                      <input class="uk-input uk-form-small" v-model="settings.position" type="number" value="">
                    </div>
                  </div>
                </li>
                <li>
                  <div>
                    <div class="h-header">Passing requirements</div>
                    <div class="uk-grid-small" uk-grid>
                      <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                        Scoping:
                      </div>
                      <div class="uk-width-auto">
                        <select class="uk-select uk-form-small" v-model="settings.score_type">
                          <option value="1">Percentage</option>
                          <option value="2">Score</option>
                          <option value="0">None</option>
                        </select>
                      </div>
                    </div>
                    <div class="uk-grid-small" uk-grid>
                      <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                        Passing score:
                      </div>
                      <div class="uk-width-1-5@s">
                        <input class="uk-input uk-form-small" type="number" v-model="settings.passing_score" placeholder="" value="">
                      </div>
                    </div>
                    <br>
                    <div class="h-header">Time limit</div>
                    <div class="uk-grid-small" uk-grid>
                      <div class="uk-width-5-5@s uk-flex uk-flex-middle">
                        <label><input class="uk-checkbox" type="checkbox" v-model="settings.has_time_limit"> <span style="margin: 0 0.5em">Time to complete the quiz </span></label>
                        <input class="uk-input uk-form-small uk-form-width-small" type="number" v-model="settings.time_limit" placeholder="" step="1" value="" style="margin: 0 0.5em"><span class="uk-text-meta">In minutes</span>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div>
                    <div class="h-header">Restriction</div>
                    <div class="uk-grid-small" uk-grid>
                      <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                        Number of attempts
                      </div>
                      <div class="uk-width-2-5@s">
                        <input class="uk-input uk-form-small" type="number" v-model="settings.attempts_number" placeholder="Example: 10" value="">
                      </div>
                      <div class="uk-width-5-5@s">
                        <label><input class="uk-checkbox" type="checkbox" v-model="settings.shuffle_questions"> <span style="margin: 0 0.5em">Shuffle questions</span></label>
                      </div>
                      <div class="uk-width-5-5@s">
                        <label><input class="uk-checkbox" type="checkbox" v-model="settings.shuffle_groups"> <span style="margin: 0 0.5em">Shuffle groups</span></label>
                      </div>
                    </div>
                    <br>
                    <label class="uk-form-label h-header">Display type</label>
                    <div class="uk-margin">
                      <select class="uk-select uk-form-small" v-model="settings.display_type">
                        <option value="1">Modern</option>
                        <option value="0">Classic</option>
                      </select>
                    </div>
                    <br>
                    <label class="uk-form-label h-header">Quiz text direction</label>
                    <div class="uk-margin">
                      <select class="uk-select uk-form-small" v-model="settings.direction">
                        <option value="0">Auto</option>
                        <option value="1">LTR</option>
                        <option value="1">RTL</option>
                      </select>
                    </div>
                    <br>
                    <div class="h-header">Feedback</div>
                    <div class="uk-grid-small" uk-grid>
                      <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                        Correct
                      </div>
                      <div class="uk-width-4-5@s">
                        <input class="uk-input uk-form-small" type="text" v-model="settings.feedback_correct" name="feedback_correct" value="">
                      </div>
                    </div>
                    <div class="uk-grid-small" uk-grid>
                      <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                        Incorrect
                      </div>
                      <div class="uk-width-4-5@s">
                        <input class="uk-input uk-form-small" type="text" v-model="settings.feedback_incorrect">
                      </div>
                    </div>
                    <div class="uk-grid-small" uk-grid>
                      <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                        Try again
                      </div>
                      <div class="uk-width-4-5@s">
                        <input class="uk-input uk-form-small" type="text" v-model="settings.feedback_retry">
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="h-header">Quiz submission</div>
                  <div class="uk-grid-small" uk-grid>
                    <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                      <label><input class="uk-checkbox" type="checkbox"> <span style="margin: 0 0.5em">Send quiz results to</span></label>
                    </div>
                    <div class="uk-width-2-5@s">
                      <input class="uk-input uk-form-small" type="text" placeholder="email@example.com">
                    </div>
                  </div>
                  <div class="uk-grid-small" uk-grid>
                    <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                      Submission button title
                    </div>
                    <div class="uk-width-2-5@s">
                      <input class="uk-input uk-form-small" type="text" v-model="settings.submission_title">
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!--Groups-->
      <draggable
          :list="groups"
          handle=".uk-sortable-handle"
          @start="handleDragStart()"
      >
      <div class="uk-margin-small" v-if="!settingTab" v-for="(group, key) in groups">
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
                      <label><input class="uk-checkbox input-shuffle-questions" type="checkbox" v-model="group.shuffleQuestions"> <span style="margin: 0 0.5em">Shuffle Questions</span></label>
                    </div>
                  </div>
                  <div class="uk-margin uk-grid-small score-section" uk-grid>
                    <div class="uk-width-1-5@m uk-flex uk-flex-middle">
                      <label>Questions number allowed to answer:</label>
                    </div>
                    <div class="uk-width-expand@m ">
                      <input type="number" class="uk-input uk-form-small input-section-allowed-number" v-model="group.allowedNumber"  placeholder="5">
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
            <draggable
                :list="group.items"
                handle=".uk-sortable-handle"
                class="list-group" group="people"
            >
              <div class="group-question" v-for="(question, questionKey) in group.items">
              <div class="uk-padding-small bg-white">
                <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                  <div class="uk-width-1-4">
                    <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                      <div class="uk-width-auto">
                        <span class="uk-sortable-handle" uk-icon="icon: table"></span> <span v-html="questionKey+1"></span> |
                      </div>
                      <div class="uk-width-expand">
                        <select class="uk-select uk-form-small" v-model="question.type">
                          <option value="1" v-html="$t('main.Short answer')"></option>
                          <option value="2" v-html="$t('main.Open end Answer')"></option>
                          <option value="3" v-html="$t('main.Single choice')"></option>
                          <option value="4" v-html="$t('main.Multiple choice')"></option>
                          <option value="5" v-html="$t('main.Drop menu')"></option>
                          <option value="6" v-html="$t('main.Fill the blank')"></option>
                          <option value="7" v-html="$t('main.Fill the blank (drag and drop)')"></option>
                          <option value="8" v-html="$t('main.Fill the blank (re arrange)')"></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="uk-width-expand">
                    <select class="uk-select uk-form-small" v-model="question.selectedQuestionItemId">
                      <option class="uk-text-muted" :value="null">Available questions</option>
                      <option v-for="questionItem in question.questionItems" :value="questionItem.id" v-html="questionItem.title"></option>
                    </select>
                  </div>
                  <div class="uk-width-1-4">
                    <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                      <div class="uk-width-expand">
                        Me.
                      </div>
                      <div class="uk-width-expand">
                        Fixed
                      </div>
                      <div class="uk-width-auto">
                        Qs. count <span :class="{'uk-text-success':question.questionItems.length > 0}">(<span v-html="question.questionItems.length"></span>)</span>
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
                        <input class="uk-input uk-form-small" type="text" @keypress="onlyNumber" placeholder="Unit no." v-model="question.unit_num" :class="{'uk-form-success': question.unit_num && question.unit_num <=  parseInt(currentUnitNum), 'uk-form-danger': question.unit_num && question.unit_num > parseInt(currentUnitNum)}">
                      </div>
                      <div class="uk-width-1-2">
                        <input class="uk-input uk-form-small" type="text" @keypress="onlyNumber" placeholder="Lesson no." v-model="question.lesson_num" :class="{'uk-form-success': question.lesson_num && question.lesson_num <= parseInt(currentLessonNum), 'uk-form-danger': question.lesson_num && question.lesson_num > parseInt(currentLessonNum)}">
                      </div>
                    </div>
                  </div>
                  <div class="uk-width-1-4">
                    <div class="uk-grid-small" uk-grid>
                      <div class="uk-width-1-2">
                        <select class="uk-select uk-form-small" v-model="question.source">
                          <option value="all">Got from</option>
                          <option value="0">Quoted</option>
                          <option value="1">Modified</option>
                          <option value="2">Out of Box</option>
                        </select>
                      </div>
                      <div class="uk-width-1-2">
                        <select class="uk-select uk-form-small" v-model="question.taxonomies_a">
                          <option value="all">Bloom TAX</option>
                          <option value="1">Create</option>
                          <option value="2">Evaluate</option>
                          <option value="3">Analyze</option>
                          <option value="4">Apply</option>
                          <option value="5">Understand</option>
                          <option value="6">Remember</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="uk-width-1-4">
                    <div class="uk-grid-small" uk-grid>
                      <div class="uk-width-1-2">
                        <Select2 v-model="question.taxonomies_b" :options="tags" :settings="{ placeholder: 'Tax-2' }" @change="myChangeEvent($event)" @select="mySelectEvent($event)" />
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
                        <label><input class="uk-checkbox" type="checkbox" v-model="question.uniform"></label>
                      </div>
                      <div class="uk-width-expand">
                        <label><input class="uk-radio" type="radio" name="setAsDefault" @change="setQuestionAsDefault(question)"></label>
                      </div>
                      <div class="uk-width-auto">
                        <button class="uk-button uk-button-primary uk-button-small" style="min-width: 75px" @click="runQuestionFilters(question)" :disabled="question.loadingMode">
                          <span v-if="question.loadingMode" uk-spinner="ratio: 0.5"></span>
                          <span v-else>Run</span>
                        </button>
                      </div>
                      <div class="uk-width-expand uk-text-right">
                        <span @click="addNewGroupQuestion(group)" class="hover-primary" uk-tooltip="title: Add new question"><span uk-icon="plus-circle"></span></span>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            </draggable>
          </div>

        </div>
      </div>
      </draggable>
      <!--End of Groups-->
      <div v-if="groups.length == 0 && !settingTab" class="uk-text-center uk-padding">
        <img class="gray-folder" data-src="/storage/assets/file_icons/folder.png" width="90" alt="" uk-img>
        <p class="uk-text-muted" v-html="'There is no available groups yet, click on the + icon to add new group'"></p>
      </div>
    </div>
  </div>
</template>


<script>
import draggable from 'vuedraggable'
import Select2 from 'v-select2-component';
export default {
  name: "Create",
  components: {
    draggable,
    Select2,
  },
  props: {
    currentUnitNum: {type:String},
    currentLessonNum: {type:String},
    lessonSlug: {type:String},
  },
  data(){
    return{
      groups: [],
      settings: {
        title: 'Unit: '+this.currentUnitNum+' - Lesson: '+this.currentLessonNum+' Quiz',
        description:'',
        position:0,
        score_type:1,
        passing_score:50,
        has_time_limit:false,
        time_limit:0,
        attempts_number:null,
        shuffle_questions:false,
        shuffle_groups:false,
        display_type:0,
        direction:0,
        feedback_correct:'Put your correct message',
        feedback_incorrect:'Put your incorrect message',
        feedback_retry:'Put your try again message',
        submission_title:'Submit',
      },
      settingTab: true,
      generatingMode:false,
      forms:[],
      showForms:false,
      defaultQuestion:null,
      tags:[],
      myOptions: [], // or [{id: key, text: value}, {id: key, text: value}]
      exceptions:[], // items that already added 
      similarity_exceptions:[], /// items that have similar (similarity_code) with the added items
    }
  },
  created() {
    this.fetchItem();
  },
  mounted() {
    this.newGroup();
  },
  methods:{
    fetchItem(){
      axios.get('/manage/store/lesson/'+this.lessonSlug+'/form/smart/get/info', {
        params: {
          // id: 12345
        }
      }).then(res => {
        var array = [];
        $.each(res.data.tags, function (index, value){
          array.push(value)
        });
        this.tags = array;
      });

    },
    openGroupSettings(key, group){
      group.editMode = !group.editMode;
      addMinyTinyEditor('.content-editor-'+key);

    },
    addNewGroupQuestion(group){
      var newId = this.generateRandomString(4);
      group.items.push(
          {
            id:newId,
            unit_num: this.defaultQuestion ? this.defaultQuestion.unit_num : null,
            unit_status: true,
            lesson_num: this.defaultQuestion ? this.defaultQuestion.lesson_num : null,
            lesson_status:true,
            source: this.defaultQuestion ? this.defaultQuestion.source : 'all',
            taxonomies_a: this.defaultQuestion ? this.defaultQuestion.taxonomies_a : 'all',
            taxonomies_b: this.defaultQuestion ? this.defaultQuestion.taxonomies_b : [],
            uniform: this.defaultQuestion ? this.defaultQuestion.uniform : false,
            loadingMode:false,
            questionItems:[], 
            selectedQuestionItemId:null,
            type: this.defaultQuestion ? this.defaultQuestion.type : 6,
          }
      );
    },
    addNewGroup(){
      if (this.settingTab){
        this.settingTab =! this.settingTab;
      }
     this.newGroup();
    },
    newGroup(){
      var newGroupItem = {
        title: 'Group title',
        description: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',
        editMode:false,
        allowedNumber:null,
        shuffleQuestions:false,
        items:[],

      };
      this.groups.push(newGroupItem);
      this.scrollToEndOfPage();
      this.addNewGroupQuestion(newGroupItem);
      return newGroupItem;
    },
    runQuestionFilters(question){
      question.loadingMode = true;
      const data = {
        id:question.id,
        unit_num:question.unit_num,
        unit_status:question.unit_status,
        lesson_num:question.lesson_num,
        lesson_status:question.lesson_status,
        source:question.source,
        taxonomies_a:question.taxonomies_a,
        taxonomies_b:question.taxonomies_b,
        uniform:question.uniform,
        type:question.type,
        similarity_exceptions:this.similarity_exceptions,
        exceptions:this.exceptions,
      };
      axios.post('/manage/store/lesson/'+this.lessonSlug+'/form/smart/get/items', data)
          .then(res => {
            question.loadingMode = false;
            question.questionItems = res.data;
            // selectedQuestionItemId:null,
            var randomQuestion =  question.questionItems[Math.floor(Math.random()*question.questionItems.length)]
            if (question.questionItems.length > 0){
              question.selectedQuestionItemId = randomQuestion.id;
              this.exceptions.push(randomQuestion.id);
              if (randomQuestion.similarity_code) {
                this.similarity_exceptions.push(randomQuestion.similarity_code);
              }
              console.log(randomQuestion.id);
            } else {
              this.$Notify({
                title: 'No questions',
                message: 'seems that there are no questions matching your search, try with another filter options.',
                type: 'warning',
                duration: 4000
              });
            }
          })
          .catch(error => {
            console.log(error);
          });

    },
    generateForm(){
      this.generatingMode = true;
      const data = {
        settings:this.settings,
        groups:this.groups,
      };
      axios.post('/manage/store/lesson/'+this.lessonSlug+'/form/smart/store', data)
          .then(res => {
            this.generatingMode = false;
            this.forms.push(res.data);
            this.showForms = true;
          })
          .catch(error => {
            console.log(error);
          });
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
    setQuestionAsDefault(question){
      this.defaultQuestion = question;
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
    generateRandomString(length) {
      var text = "";
      var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      for (var i = 0; i < length; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
      return text;
    },
    // dragging methods
    handleDragStart(){
      this.groups.forEach((group, key) =>{
        group.editMode = false;
      });
    },
    // select 2
    myChangeEvent(val){
      // console.log(val);
    },
    mySelectEvent({id, text}){
      // console.log({id, text})
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
  background-color: rgba(255,255,255,0.5);
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
.h-0{
  height: 0px;
  overflow: hidden;
}
.submit-form{
  min-width: 150px;
}

</style>