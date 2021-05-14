<template>
  <div>
    <div class="quiz-section">
      <div class="uk-container" v-if="!loadingMode">
        <!--has limit time-->
        <div v-if="!examStarted">
          <div class="uk-card uk-card-default uk-text-center uk-padding">
            <div class="uk-margin-small">
              <span uk-icon="icon: info; ratio: 2" style="color: #faa05a ; background-color: #fff2e8; border-radius: 50%; padding: 8px"></span>
            </div>
            <p class="uk-margin-remove">{{$t('main.Dear', {name: 'student'})}} {{$t('main.this quiz have limited time to answer, which is')}} {{form.time_limit}} {{$t('main._Minutes')}}</p>
            <p class="uk-margin-remove" v-html="$t('main.Are you sure that you want to start the quiz?')">
            </p>
            <br>
            <div>
              <button class="uk-button uk-button-primary start-quiz" @click="startExam()">{{$t('main.Yes, Start the quiz')}}</button>
            </div>
          </div>
        </div>
        <!--has no time limit-->
        <div v-else>
          <div v-if="examMode" v-bind:style="{ direction: direction }">
            <!--Form info-->
            <div class="uk-margin-medium">
              <div style="margin-bottom: 10px" v-if="form.description">
                <div class="uk-card uk-card-default uk-card-body uk-padding-small" v-html="form.description">
                </div>
              </div>
              <span class="disabled"><label class="uk-text-danger"><input class="uk-checkbox uk-checkbox-danger uk-checkbox-rounded" type="checkbox" checked> {{$t('main.Pass')}}</label></span>
              <br>
              <span class="disabled"><label class="uk-text-warning"><input class="uk-checkbox uk-checkbox-warning uk-checkbox-rounded" type="checkbox" checked> {{$t('main.Review')}}</label></span>
            </div>
            <!--Form info-->
            <div class="uk-grid-small uk-child-width-1-1" uk-grid>
              <div :id="'group-'+group.id" v-for="(group, groupKey) in groups" :class="{'hidden-div': currentGroupKey != groupKey}">

                <div class="uk-grid-collapse uk-child-width-1-1" uk-grid>
                  <div>
                    <div>
                      <!-- section info -->
                      <div class="uk-grid-collapse uk-text-center" uk-grid>
                        <div v-if="group.title" class="uk-width-auto@m">
                          <div class="uk-tile uk-tile-secondary uk-box-shadow-small" style="border-radius: 10px 10px 0 0; padding: 5px 20px; margin: 0 10px">
                            <p class="uk-h5" v-html="group.title"></p>
                          </div>
                        </div>
                      </div>
                      <!-- section -->
                      <div :class="{'uk-card uk-card-default uk-padding-small margin-bottom':form.display_type == 0 }">
                        <!-- section desc -->
                        <div class="uk-grid-collapse margin-bottom" uk-grid :class="{'uk-card uk-card-default uk-padding-small':form.display_type == 1 }">
                          <div class="uk-width-expand@m" v-html="group.description">
                          </div>
                          <div class="uk-width-auto@m uk-text-success">
                            <span v-html="group.score"></span> Marks
                          </div>
                          <div class="uk-width-1-1 blanks-row uk-margin-small" v-if="group.draggable_blanks.length > 0">
                              <!--draggable blanks-->
                              <div class="blank-word uk-box-shadow-hover-medium" v-for="(draggableBlank, draggableBlankKey) in group.draggable_blanks"
                                   v-html="draggableBlank.value"
                                   v-if="!isDropped(group, draggableBlank.value)"
                                   draggable @dragstart='startDrag(draggableBlank.question_id, draggableBlank.value, draggableBlankKey)'
                                   @click="insertInNextBlank(group, draggableBlank.question_id, draggableBlank.value)"
                              >
                              </div>
                            </div>
                        </div>
                        <!-- section questions -->
                        <div class="uk-grid-collapse" uk-grid>
                          <!--questions-->
                          <div v-for="(question, key) in group.items" v-if="question.type != 0" class="uk-width-1-1@m uk-width-1-1@s" :class="{ 'uk-background-warning-light': question.review, 'uk-background-danger-light': question.auto_leave, 'margin-bottom':form.display_type == 1  }">
                            <div :class="{'uk-card uk-card-default uk-padding-small':form.display_type == 1 }">
                              <div :id="'question-'+question.id" class="uk-grid-collapse question-row" uk-grid>
                                <div class="uk-width-auto@m">
                                  <span v-html="key"></span>:
                                </div>
                                <div class="uk-width-expand@m question" style="padding: 0 5px">
                                  <input type="hidden" name="items_id[]" :value="question.id">
                                  <span class="question-title" v-html="question.title"></span>
                                  <span v-if="question.type == 1">
                                    <input class="input-classic" :name="'item_answer['+question.id+']'"  type="text" :placeholder="$t('main.Your answer')" autocomplete="off">
                                  </span>
                                  <span v-else-if="question.type == 2">
                                    <textarea class="uk-textarea" :name="'item_answer['+question.id+']'" rows="5" placeholder="..." style="background-color: transparent" autocomplete="off"></textarea>
                                  </span>
                                  <span v-else-if="question.type == 3">
                                        <label v-for="option in question.options" style="margin: 0 2px"><input class="uk-radio" type="radio" :name="'item_answer['+question.id+']'" :value="option.title"> {{option.title}}</label>
                                  </span>
                                  <span v-else-if="question.type == 4">
    <!--                            <vs-checkbox v-for="option in question.options" :name="'item_answer['+question.id+'][]'" :value="option.title"> {{option.title}} </vs-checkbox>-->
                                        <label v-for="option in question.options" style="margin: 0 2px"><input class="uk-checkbox" :name="'item_answer['+question.id+'][]'" :value="option.title" type="checkbox"> {{option.title}}</label>
                                  </span>
                                  <span v-else-if="question.type == 5">
                                    <select class="uk-select uk-form-small uk-form-width-small" :name="'item_answer['+question.id+']'" style="padding:0 20px">
                                        <option value="" v-html="$t('main.choose answer')"></option>
                                        <option v-for="option in question.options" :value="option.title" v-html="option.title"></option>
                                    </select>
                                  </span>
                                  <div v-else-if="question.type == 6" v-html="question.blank_paragraph">
                                  </div>
                                  <div v-else-if="question.type == 7">
                                    <div class="drop-zone"
                                         @drop.prevent="onDrop(group, question)"
                                         @dragover.prevent>
                                      <div class="drop-zone-content" v-html="question.blank_paragraph"></div>
                                    </div>
                                  </div>
                                  <div v-else-if="question.type == 8">
                                    <!--draggable blanks-->
                                    <div style="display: inline-block" class="drop-zone"
                                         @drop.prevent="onDrop(group, question)"
                                         @dragover.prevent>
                                      <div class="drop-zone-content" v-html="question.blank_paragraph"></div>
                                    </div>
                                    <div class="blank-word uk-box-shadow-hover-medium" v-for="(draggableBlank, draggableBlankKey) in question.blanks"
                                         v-html="draggableBlank"
                                         v-if="!isQuestionDropped(group, question, draggableBlank)"
                                         draggable @dragstart='startDrag(question.id, draggableBlank, draggableBlankKey)'
                                         @click="insertInNextBlank(group, question.id, draggableBlank, false)"
                                    >
                                    </div>
                                  </div>
                                </div>
                                <div class="uk-width-auto@m uk-text-lighter">
                                  <span v-html="question.score"></span> Marks
                                  <label><input :uk-tooltip="$t('main.Pass')" class="uk-checkbox uk-checkbox-danger uk-checkbox-rounded leave-question" type="checkbox" :name="'item_leave['+question.id+']'" :value="question.id" @click="question.auto_leave = !question.auto_leave" :checked="question.auto_leave"></label>
                                  <label><input :uk-tooltip="$t('main.Review')" class="uk-checkbox uk-checkbox-warning uk-checkbox-rounded review-question" name="review" type="checkbox" @click="question.review = !question.review"></label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>

                    </div>
                  </div>
                  <div>
                    <!-- section actions -->
                    <div>
                      <div class="uk-grid-collapse" uk-grid>
                        <div class="uk-width-auto">
                          <span v-if="groupKey > 0" class="uk-button uk-button-secondary section-navigation prev-section" @click="prevGroup()" data-value="0" v-html="$t('main.Previous')"></span>
                        </div>
                        <div class="uk-width-expand"></div>
                        <div class="uk-width-auto">
                          <span v-if="groupKey != groupsCount" class="uk-button uk-button-secondary section-navigation next-section" @click="nextGroup()" data-value="1" v-html="$t('main.Next')"></span>
                          <span v-else class="uk-button uk-button-primary section-navigation" data-value="3" v-html="form.properties.submission_title" @click="submit()"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


              </div>
            </div>
          </div>
          <div v-else>
            <div class="uk-margin" style="overflow: hidden">
              <div class="uk-card uk-card-default uk-text-center" >

                <div class="uk-child-width-1-2@s uk-flex uk-flex-middle uk-flex-center" uk-grid>
                  <div class="uk-padding">
                    <div v-if="evaluationStatus == 0">
                      <div>
                        <span uk-spinner="ratio: 1.5" style="color: #1e87f0 ; background-color: #edf6ff; border-radius: 50%; padding: 6px"></span>
                      </div>
                      <h4 class="uk-text-primary uk-margin-remove" v-html="$t('main.Evaluation in process, please wait')"></h4>
                    </div>
                    <div v-else>
                      <div v-if="responseArray.status == 1">
                        <div v-if="responseArray.passing_score_status == 1">
                          <span uk-icon="icon: check; ratio: 2" style="color: #32d296 ; background-color: #edfbf6; border-radius: 50%; padding: 8px"></span>
                          <h4 class="uk-text-success uk-margin-remove" v-html="$t('main.Passed successfully')"></h4>
                          <p class="uk-margin-small" v-html="$t('main.Congratulations! you have passed')"></p>
                        </div>
                        <div v-else>
                          <span uk-icon="icon: warning; ratio: 2.4" style="color: #f0506e ; background-color: #fef4f6; border-radius: 50%; padding: 5px"></span>
                          <h4 class="uk-text-danger uk-margin-remove" v-html="$t('main.Failed')"></h4>
                          <p class="uk-margin-small" v-html="$t('main.Hard luck! unfortunately')"> </p>
                        </div>
                      </div>
                      <div v-else-if="responseArray.status == 2">
                        <div>
                          <span uk-icon="icon: info; ratio: 2" style="color: #faa05a ; background-color: #fff2e8; border-radius: 50%; padding: 8px"></span>
                          <h4 class="uk-text-warning uk-margin-remove" v-html="$t('main.Your answers has been submitted')"></h4>
                          <p class="uk-margin-small" v-html="$t('main.Dear student, your answers have been submitted and will be evaluated soon')"></p>
                          <a class="uk-button uk-button-default uk-width-1-3" :href="backUrl" v-html="$t('main.Back')"></a>
                        </div>
                      </div>
                    </div>
                    <div class="" v-if="evaluationStatus == 1 && responseArray.status == 1">
                      <div class="uk-flex uk-flex-center">
                        <div class="uk-width-1-2" :class="{'uk-alert-success':responseArray.passing_score_status == 1,'uk-alert-danger':responseArray.passing_score_status == 0 }" uk-alert>
                          <p v-html="responseArray.score"></p>
                        </div>
                      </div>
                      <div>
                        <a v-if="responseArray.status != 2" class="uk-button uk-button-primary uk-width-auto" :href="responseArray.link+'/?back='+backUrl" v-html="$t('main.View results')"></a>
                        <a class="uk-button uk-button-secondary uk-width-auto" @click="refreshForm()" v-html="$t('main.Re try')"></a>
                        <a class="uk-button uk-button-default uk-width-auto" :href="backUrl" v-html="$t('main.Back')"></a>
                      </div>
                    </div>

                  </div>
                </div>

                <progress style="height: 5px; border-radius: 0px" id="js-progressbar" class="uk-progress" :value="evaluationPercentage" max="100"></progress>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
    <!--CountDown-->
    <div v-if="showTimer" style="z-index: 99; position: fixed; bottom: 0; margin-bottom: 10px">
      <div class="uk-box-shadow-small" style="padding: 5px; background-color: rgba(255, 255, 255, 0.9); border-radius: 5px; direction: ltr">

        <!--timer-->
        <countdown ref="countdown" @progress="handleCountdownProgress" :time="quizItemAnswerTime * 60 * 1000">
          <!--        <template slot-scope="props">Time Remaining：{{ props.days }} days, {{ props.hours }} hours, {{ props.minutes }} minutes, {{ props.seconds }} seconds.</template>-->
          <template slot-scope="props">

            <div class="uk-grid-collapse uk-child-width-expand" uk-grid>
              <div>
                <div class="uk-text-center" style="background-color: #F4F5F7; border-radius: 5px; padding: 5px 10px; margin: 5px">
                  <h1 class="uk-margin-remove uk-text-bold" :class="quizItemAnswerColorClass">{{ props.minutes }}</h1>
                  <p class="uk-margin-remove uk-text-muted"><small >Minutes</small></p>
                </div>
              </div>
              <div>
                <div class="uk-text-center" style="background-color: #F4F5F7; border-radius: 5px; padding: 5px 10px; margin: 5px">
                  <h1 class="uk-margin-remove uk-text-bold" :class="quizItemAnswerColorClass">{{ props.seconds }}</h1>
                  <p class="uk-margin-remove uk-text-muted"><small >Seconds</small></p>
                </div>
              </div>
            </div>

          </template>
        </countdown>

      </div>
    </div>
    <!--dialog-->
    <vs-dialog not-close width="550px" not-center v-model="showDialog">
      <template #header>
        <h4 class="uk-margin-remove uk-text-warning">
          <b>Alert</b>
        </h4>
      </template>

      <div class="con-content">
        <p class="not-margin">
          <b>Dear student</b><br>
          You have <b v-html="leaveCount"></b> Questions to review before submitting your answers, do you want to continue?
        </p>
      </div>

      <template #footer>
        <div class="con-footer">
          <button class="uk-button uk-button-small uk-button-primary" @click="postResponse()" v-html="$t('main.Ok')"></button>
          <button class="uk-button uk-button-small uk-button-default" @click="showDialog=false" v-html="$t('main.Cancel')"></button>
        </div>
      </template>
    </vs-dialog>
  </div>
</template>

<script>
import Vue from 'vue';
import VueCountdown from '@chenfengyuan/vue-countdown';
Vue.component(VueCountdown.name, VueCountdown);
export default {
name: "Show",
  props: [
    'slug',
    'backUrl',
  ],

  data(){
    return {
      form:null,
      loadingMode:true,
      groups:null,
      groupsCount:0,
      currentGroupKey:0,
      showDialog:false,
      examMode:true,
      examStarted:false,
      showTimer:false,
      evaluationStatus:0,
      evaluationPercentage:10,
      canSubmit:false,
      direction:'',
      itemId:[],
      answer:[],
      itemsAnswers:[],
      leaveCount:0,
      draggedBlank:'',
      draggedBlankKey:null,
      draggedBlankQuestionId:null,
      droppedBlanksArray:[],
      responseArray:[],
      quizItemAnswerTime:0,
      quizItemAnswerColorClass:'uk-text-primary',

      //

    }
  },
  created() {
    this.fetchItem();

  },
  mounted() {

  },
  methods: {
    startExam(){
      this.examStarted = true;
      this.showTimer = true;
      var submitAfter = this.quizItemAnswerTime * 60 * 1000;
      setTimeout(()=>{
            this.submit();
          },submitAfter
      );
    },
    fetchItem(){
      axios.get('/form/'+this.slug+'/get/item', {
        params: {
          id: null,
        }
      }).then(res => {
        $('.full-screen-spinner').fadeOut();
        this.form = res.data;
        this.direction = this.form.direction;
        this.groups = this.form.grouped_questions;
        // console.log(this.groups);
        this.groupsCount = this.groups.length;
        if(this.groupsCount > 0){
          this.groupsCount = this.groupsCount - 1;
        }
        this.loadingMode = false;
        if (this.form.has_time_limit){
          this.quizItemAnswerTime = this.form.time_limit;
        }else{
          this.examStarted =  true;
        }
      });
      },
    nextGroup(){
      this.currentGroupKey++;
    },
    prevGroup(){
      this.currentGroupKey--;
    },
    submit(){
      this.showTimer = false;
      this.leaveCount = $(".review-question:checked").length;
      if(this.leaveCount > 0){
        this.showDialog = true;
      } else {
        this.postResponse();
      }
      //
    },
    postResponse(){
      this.showDialog = false;
      this.itemsAnswers =  this.buildAnswersArray();
      this.examMode = false;
      var data = {
        answers: this.itemsAnswers,
      };
      var config = {
        onUploadProgress: function (progressEvent) {
          this.evaluationPercentage = parseInt(Math.round((progressEvent.loaded * 100) / progressEvent.total))
        }.bind(this)
      }
      axios.post('/form/'+this.slug+'/send/response', data, config)
          .then(res => {
              this.responseArray = res.data;
              this.evaluationStatus = 1;
            // this.updateProgressPercentage(100);

          })
          .catch(error => {

          });


    },
    updateProgressPercentage(value){
      this.evaluationPercentage = value;
    },
    buildAnswersArray(){
      // TODO: temp solution
      var answers =  [];
      var id = null;
      var answer = null;
      var answerArray = null;
      var selectedAnswers = null;
      var selectedAnswersArray = [];
      $.each( this.groups, function( key, group ) {
        // each item
        $.each( group.items, function( key, item ) {
          if (item.type != 0){
            answer = '';
            if(item.type == 1 || item.type == 2 || item.type == 5){
              answer = $("[name='item_answer["+item.id+"]']").val();
            } else if ( item.type == 3){
              answer = $("[name='item_answer["+item.id+"]']:checked").val();
            }
            else if ( item.type == 4){
              selectedAnswersArray = [];
              selectedAnswers = $("[name='item_answer["+item.id+"][]']:checked");
              $.each( selectedAnswers, function( key, selectedAnswer ) {
                selectedAnswersArray[key] = $(selectedAnswer).val();
              });
              answer = selectedAnswersArray;
            }else if ( item.type == 6){
              selectedAnswersArray = [];
              selectedAnswers = $('#question-'+item.id).find('.input-blank');
              $.each( selectedAnswers, function( key, selectedAnswer ) {
                selectedAnswersArray[key] = $(selectedAnswer).val();
              });
              answer = selectedAnswersArray;
            }else if (item.type == 7 ||  item.type == 8){
              selectedAnswersArray = [];
              selectedAnswers = $('#question-'+item.id).find('.droppable-blank-input');
              $.each( selectedAnswers, function( key, selectedAnswer ) {
                selectedAnswersArray[key] = $(selectedAnswer).val();
              });
              answer = selectedAnswersArray;
            }
            // add answers
            var leaveThisQuestion = $("[name='item_leave["+item.id+"]']:checked");
            var answersArray = {
              id: item.id,
              answers: answer,
              answer_status: leaveThisQuestion.length > 0 ? 0 : 1, // 0 left , 1 answered
            };
            answers.push(answersArray)
          }
        });
      });
      return answers;
    },
    getLeaveClass(group, item, key){
      return '';
    },
    startDrag(questionID, blank, blankKey){
      hoveredItem = null;
      this.draggedBlank = blank;
      this.draggedBlankKey = blankKey;
      this.draggedBlankQuestionId = questionID;

    },
    onDrop (group, question) {
      if(hoveredItem != null){
        var blank = this.draggedBlank;
        var item = $(hoveredItem);
        this.insertBlank(group, question.id, item, blank);
      }
    },
    insertBlank(group, questionId, item, blank){
      var blankDataKey = group.id+'-'+blank;
      var html = `<input class="droppable-blank-input" name="item_answer['`+questionId+`'][]" type="hidden" value="`+blank+`">
        <div class="blank-word dropped-blank-item" data-key="`+blankDataKey+`" data-group-id="`+group.id+`" data-question-id="`+questionId+`">`+blank+` <span class="remove-blank" uk-icon="icon: close; ratio: 0.7"></span></div>
        `;
        item.html(html);
      this.removeBlank(group, questionId);
      this.refreshDroppedBlanksArray(group, questionId, blankDataKey);
      this.refreshQuestionDroppedBlanksArray(group, questionId, blankDataKey);
    },
    insertInNextBlank(group, questionId, blank, inGroup = true){
      var droppableBlanks = $('#group-'+group.id).find('.droppable-blank');
      if (!inGroup){
        droppableBlanks = $('#question-'+questionId).find('.droppable-blank');
      }
      var nextDroppableBlank = null;
      $.each( droppableBlanks, function( key, droppableBlankItem ) {
        if ($(droppableBlankItem).html() == ''){ // blank item
          if (!nextDroppableBlank){
            nextDroppableBlank = droppableBlankItem;
          }
        }
      });
      this.insertBlank(group, questionId, $(nextDroppableBlank), blank);
    },
    removeBlank(group, questionId){
      var appVue = this;
      var currentGroup = null;

      $('.dropped-blank-item').off('click').click(function (){
        var blank = $(this);
        var blankGroup = $(this).attr('data-group-id');
        blank.parent().html('');
        $.each(appVue.groups, function (index, group){
          if (group.id == blankGroup){
            currentGroup = group;
          }
        });
        appVue.refreshDroppedBlanksArray(currentGroup)
        appVue.refreshQuestionDroppedBlanksArray(group, questionId);

      });
    },
    isDropped(group, blank){
      var blankDataKey = group.id+'-'+blank;
      return group.dropped_blanks.includes(blankDataKey);
    },
    isQuestionDropped(group, question, blank){
      var blankDataKey = group.id+'-'+blank;
      return question.dropped_blanks.includes(blankDataKey);
    },
    refreshDroppedBlanksArray(group, questionId = null){
      var droppableBlanks = $('#group-'+group.id).find('.droppable-blank');
      var newArray = [];
      $.each( droppableBlanks, function( key, item ) {
        var questionBlankDataKey = $(this).find('.dropped-blank-item').attr('data-key');
        if(questionBlankDataKey !== undefined){
          newArray.push(questionBlankDataKey);
        }
      });
      group.dropped_blanks = newArray;

    },
    refreshQuestionDroppedBlanksArray(group, questionId = null){
      var droppableBlanks = $('#question-'+questionId).find('.droppable-blank');
      var newArray = [];
      $.each( droppableBlanks, function( key, item ) {
        var questionBlankDataKey = $(this).find('.dropped-blank-item').attr('data-key');
        if(questionBlankDataKey !== undefined){
          newArray.push(questionBlankDataKey);
        }
      });
      Object.keys(group.items).forEach(key => {
        var question = group.items[key];
        if (question.id == questionId){
          question.dropped_blanks = newArray;
        }
      });
    },
    handleCountdownProgress(data) {

      if (this.form.has_time_limit && this.examStarted){
        if(data.totalMinutes == 0 && data.totalSeconds == 15){
          this.quizItemAnswerColorClass = 'uk-text-warning';
        }
      }

      // console.log(data.days);
      // console.log(data.hours);
      // console.log(data.minutes);
      // console.log(data.seconds);
      // console.log(data.milliseconds);
      // console.log(data.totalDays);
      // console.log(data.totalHours);
      // console.log(data.totalMinutes);
      // console.log(data.totalSeconds);
      // console.log(data.totalMilliseconds);

    },
    refreshForm(){
      location.reload();
    },
  },
}
</script>

<style scoped>
/*:root {*/
/*  --vs-radius: 10px !important;*/
/*}*/
.disabled{
  pointer-events: none;
}
.blanks-row{
  padding: 10px 0;
  display: inline-block;
  min-width: 150px;
  min-height: 25px;
}
.blank-word{
  margin: 0 2px;
  padding: 5px 15px;
  display: inline-block;
  background-color: var(--text-primary);
  border-radius: 5px;
  color: white;
}
.blank-word:hover{
  cursor: pointer;
}

.drag-el {
  background-color: #fff;
  margin-bottom: 10px;
  padding: 5px;
}
.dropped-blank{
  opacity: 0.5;
}
.margin-bottom{
  margin-bottom: 10px;
}
</style>