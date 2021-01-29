<template>
  <div>
    <div v-if="itemCount > 0" class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-small uk-padding-small" style="overflow: hidden">
      <h5 class="text-highlighted uk-text-bold">Memorize</h5>
      <!--      <p>{{ $t('main.Dear', {name: 'visitor'}) }}</p>-->
      <p class="uk-margin-small">{{ $t('main._memorize dear student', {name: 'student'}) }}</p>
      <div class="uk-text-center" style="padding: 20px 40px">
        <div class="uk-grid-small uk-child-width-1-6@xl uk-child-width-1-5@l uk-child-width-1-4@m uk-child-width-1-3@s uk-child-width-1-2 uk-flex uk-flex-center uk-text-center" uk-grid>
          <div v-for="(item, key) in items" v-if="item && item.properties && item.properties.level && item.properties.level == 1">
            <div class="uk-card uk-card-body memorize-item uk-box-shadow-hover-medium" v-html="item.title" style="padding:10px 20px">
            </div>
          </div>
        </div>
      </div>
      <div class="uk-text-center uk-margin-small">
        <a class="uk-button uk-button-primary open-" href="#modal-sections" uk-toggle v-html="$t('main.Start the memorize test')"></a>
      </div>
    </div>
    <div>
      <div id="modal-sections" class="" uk-modal="bg-close: false">
        <div class="uk-modal-dialog uk-width-3-5@m uk-width-1-1@s">
          <div class="uk-modal-body">
            <div v-if="quizCompleted" class="uk-padding uk-text-center">
              <span class="uk-icon-button" uk-icon="check" style="background-color: #DEF7EC; color: #32d296"></span>
              <div class="uk-padding-small">
                <h3 class="uk-margin-remove" v-html="$t('main.Congratulations!')"></h3>
                <p class="uk-margin-remove" v-html="$t('main.You completed the quiz')"></p>
              </div>
              <div class="uk-width-expend">
                <button class="uk-button uk-button-primary uk-modal-close" @click="closeMemorizeQuiz()" type="button" v-html="$t('main.Close')"></button>
              </div>
            </div>

            <div v-else-if="previewItemMode" class="uk-grid-small" uk-grid uk-height-match="target: > div > .uk-placeholder">

              <div class="uk-width-3-5@m uk-width-1-1@s">
                <div class="uk-placeholder uk-padding-small" v-if="previewItem">
                  <h1 class="uk-text-primary uk-text-bold" v-html="previewItem.title"></h1>
                  <p v-html="previewItem.description"></p>
                </div>
              </div>
              <div class="uk-width-2-5@m uk-width-1-1@s">
                <div class="uk-placeholder uk-padding-small">
                  <div>
                    <div v-if="previewItemAudioUrl">
                      <audio v-bind:src="previewItemAudioUrl" controls controlsList="nodownload" style="width: 100%">
                        <source type="audio/mpeg">
                      </audio>
                    </div>
                    <div class="uk-margin-small" v-if="previewItemImageUrl">
                      <img v-bind:data-src="previewItemImageUrl" alt="" uk-img style="border-radius: 10px; width: 100%; object-fit:cover">
                    </div>
                  </div>
                </div>
              </div>
              <div class="uk-width-expend">
                <button @click.prevent="startQuiz()" class="uk-button uk-button-primary" v-html="$t('main.Quiz me')"></button>
              </div>
            </div>
            <div v-else-if="examItemMode">
              <div class="uk-placeholder uk-padding-small">
                <div class="uk-grid-small" uk-grid>
                  <div class="uk-width-expand@m uk-width-1-1@s"><h1 class="uk-text-primary uk-text-bold" v-html="quizItem.title"></h1></div>
                  <div class="uk-width-auto@m uk-width-1-1@s">
                    <!--timer-->
                    <countdown ref="countdown" @progress="handleCountdownProgress" :time="quizItemAnswerTime * 1000">
                      <!--        <template slot-scope="props">Time Remaining：{{ props.days }} days, {{ props.hours }} hours, {{ props.minutes }} minutes, {{ props.seconds }} seconds.</template>-->
                      <template slot-scope="props">
                        <div class="uk-text-center" style="background-color: #F4F5F7; border-radius: 5px; padding: 5px 10px">
                          <h1 class="uk-margin-remove uk-text-bold uk-text-danger">{{ props.seconds }}</h1>
                          <p class="uk-margin-remove uk-text-muted"><small >Seconds</small></p>
                        </div>

                      </template>
                    </countdown>
                  </div>
                  <div class="uk-width-extend uk-flex uk-flex-center">
                    <div class="uk-width-3-4@m uk-width-1-1@s " :class="{' disabled ':!isAllowToAnswer}">
                      <div class="uk-grid-small uk-grid-match uk-child-width-1-1@s uk-child-width-1-2@m " uk-grid uk-height-match="target: > div > div > label > .uk-card">
                        <div class="uk-flex uk-flex-middle uk-text-center"  v-for="(answer, key) in quizItemAnswers" v-if="key < 4">
                          <!-- if type 20 or 21(term) -->
                          <div v-if="quizItemAnswerType == 20 || quizItemAnswerType == 21 ">
                            <label @click.prevent="submitAnswer(quizItem.id, answer.id)">
                              <div class="uk-card uk-card-body uk-box-shadow-hover-medium uk-padding-remove answer-item" :class="{' answered ':quizItemAnsweredId,' correct ':answer.status == 1, ' incorrect ':answer.status == 0}">
                                <span class="uk-icon-button status-icon " :class="answer.status == 1 ? 'correct-answer-icon ' : 'incorrect-answer-icon '" :uk-icon="answer.status == 1 ? 'check' : 'close'"></span>
                                <div class="uk-padding-small">
                                  <input type="radio" name="answer" class="answer-input"> <span v-html="answer.title"></span>
                                </div>
                              </div>
                            </label>
                          </div>

                          <!-- if type 30 (term) -->
                          <div v-else-if="quizItemAnswerType == 30">
                            <label @click.prevent="submitAnswer(quizItem.id, answer.id)">
                              <div class="uk-card uk-card-body uk-box-shadow-hover-medium uk-padding-remove answer-item" :class="{' answered ':quizItemAnsweredId,' correct ':answer.status == 1, ' incorrect ':answer.status == 0}">
                                <span class="uk-icon-button status-icon " :class="answer.status == 1 ? 'correct-answer-icon ' : 'incorrect-answer-icon '" :uk-icon="answer.status == 1 ? 'check' : 'close'"></span>
                                <div style="padding: 10px">
                                  <img v-bind:data-src="answer.media_url" alt="" uk-img style="border-radius: 10px; height:100px; object-fit:cover">
                                </div>
                              </div>
                            </label>
                          </div>

                          <!-- if type 31 (term) -->
                          <div v-else-if="quizItemAnswerType == 31">
                            <div style="margin-bottom: 10px">
                              <audio v-bind:src="answer.media_url" controls controlsList="nodownload" style="width: 100%">
                                <source type="audio/mpeg">
                              </audio>
                            </div>
                            <label @click.prevent="submitAnswer(quizItem.id, answer.id)">
                              <div class="uk-card uk-card-body uk-box-shadow-hover-medium uk-padding-remove answer-item" :class="{' answered ':quizItemAnsweredId,' correct ':answer.status == 1, ' incorrect ':answer.status == 0}">
                                <span class="uk-icon-button status-icon " :class="answer.status == 1 ? 'correct-answer-icon ' : 'incorrect-answer-icon '" :uk-icon="answer.status == 1 ? 'check' : 'close'"></span>
                                <div class="uk-padding-small">
                                  ({{alphaBatArr[key]}}) {{$t('main._select')}}
                                </div>
                              </div>
                            </label>
                          </div>


                        </div>
                      </div>
                      <div class="uk-margin-small">
                        <progress id="js-progressbar" class="uk-progress"  :value="timeLineProgress" max="100"></progress>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import VueCountdown from '@chenfengyuan/vue-countdown';

Vue.component(VueCountdown.name, VueCountdown);
export default {
  name: "Memorize",
  props: [
    'postTitle',
    'lessonSlug',
  ],
  data(){
    return{
      name: 'mehmet',
      alphaBatArr: ['A','B','C','D'],
      items: [],
      itemCount:0,
      // memorize
      previewItemMode:false,
      examItemMode:false,
      previewItem:null,
      previewItemImageUrl:null,
      previewItemAudioUrl:null,
      currentItemKey:0,
      quizCompleted:false,
      quizItem:null,
      quizItemAnswers:[],
      quizItemKey:0,
      quizItemAnsweredId:null,
      quizItemAnswerType:0,
      timeLineProgress: 0,
      quizItemAnswerTotalTime: null,
      quizItemAnswerTime: null,
      isAllowToAnswer:false,
      wrongAnsweredIdArray:[],
    }
  },
  created() {
    this.fetchItems();
  },
  methods:{
    fetchItems(){
      axios.get('/api/product/lesson/'+this.lessonSlug+'/memorize/items', {
        params: {
          // id: 12345
        }
      }).then(res => {
        $('.full-screen-spinner').fadeOut();
        this.items = res.data;
        this.itemCount = this.items.length;
        if(this.itemCount > 0){
          this.buildMemorizeItem(this.currentItemKey);
        }else{
          this.$emit('updateViewContent', true);
        }
        $()
      });
    },
    buildMemorizeItem(itemKey){
      // build preview
      this.isAllowToAnswer = true;
      this.previewItem = this.items[itemKey];
      if (this.previewItem){
        var itemImages = this.previewItem.answers[30]; // 30 refer to images
        var itemAudio = this.previewItem.answers[31]; // 30 refer to Audio
        var selectedImage = null;
        var selectedAudio = null;
        $.each( itemImages, function( key, image ) {
          if (image.status === 1){
            if(selectedImage == null){
              selectedImage = image.media_url;
            }
          }
        });
        this.previewItemImageUrl = selectedImage;
        // get audio
        $.each( itemAudio, function( key, audio ) {
          if (audio.status === 1){
            if(selectedAudio == null){
              selectedAudio = audio.media_url;
            }
          }
        });
        this.previewItemAudioUrl = selectedAudio;
        // build quiz
        var quizItemKey = itemKey;
        this.previewItemMode = true;
        this.examItemMode = false;
        this.quizItemAnsweredId = null;
        this.timeLineProgress = null;
        this.quizItemAnswers = [];
        this.timeLineProgress = 0;
        this.quizItemAnswerTime = null;
        this.quizItemAnswerTotalTime = null;
        this.quizItem = this.items[quizItemKey];
        var myArray = this.quizItem.type_array;
        this.quizItemAnswerType = myArray[Math.floor(Math.random()*myArray.length)];
        // this.quizItemAnswerType = 20;
        if (this.quizItem.answers){
          this.quizItemAnswers = this.randomList(this.quizItem.answers[this.quizItemAnswerType]);
        }
      }
    },
    randomList: function(array){
      var currentIndex = array.length, temporaryValue, randomIndex;

      // While there remain elements to shuffle...
      while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        // And swap it with the current element.
        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
      }

      return array;
    },
    submitAnswer(quizItemID, answerId){
      this.quizItemAnsweredId = answerId;
      this.$refs.countdown.abort();
      this.quizItemAnswerTotalTime =  0;
      this.timeLineProgress = 100;
      // check if correct or not
      var status = 0;
      $.each(this.quizItemAnswers,  function (key , answer){
        if (answer.id == answerId){
          if (answer.status == 1){
            status = 1;
          }
        }
      });
      if (status == 0){ // wrong
        this.wrongAnsweredIdArray.push(quizItemID);
      }else{ // correct
        this.wrongAnsweredIdArray = this.removeFromArray(this.wrongAnsweredIdArray, quizItemID);
      }
      setTimeout(()=>{
        this.openNextPreview();
          },2000
      );
    },
    removeFromArray(arr, value){
      return arr.filter(function(ele){
        return ele != value;
      });
    },
    startQuiz(){
      this.quizItemAnswerTime =  this.quizItem.properties.time_to_answer;
      this.quizItemAnswerTotalTime =  this.quizItem.properties.time_to_answer;
      this.previewItemMode = false;
      this.examItemMode = true;
    },
    openNextPreview(){
      this.isAllowToAnswer = false;
      if (!this.previewItemMode){
        this.currentItemKey++;
        if (this.currentItemKey < this.itemCount){
          this.buildMemorizeItem(this.currentItemKey)
        }else{

          if (this.wrongAnsweredIdArray.length > 0){
            var myArray = this.wrongAnsweredIdArray;
            var selectedIdToReQuiz = myArray[Math.floor(Math.random()*myArray.length)];
            var reQuizKey = null;
            $.each(this.items,  function (key , item){
              if (item.id == selectedIdToReQuiz){
                reQuizKey = key;
              }
            });
            this.buildMemorizeItem(reQuizKey);
          }else{
            this.quizCompleted = true;
            // view content
            this.$emit('updateViewContent', true);
          }
        }
      }
    },
    handleCountdownProgress(data) {
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
      if (this.quizItemAnsweredId == null){
        this.timeLineProgress = ((this.quizItemAnswerTotalTime - data.totalSeconds)/this.quizItemAnswerTotalTime) * 100;
        if (data.totalSeconds == 1){
          setTimeout(()=>{
            this.timeLineProgress = 90;
            if (this.quizItemAnsweredId == null){
              this.quizItemAnswerTime = 0;
              this.submitAnswer(this.quizItem.id, 0);
            }else{
              this.timeLineProgress = 100;
            }
              },1000
          );
        }

      }
    },
    closeMemorizeQuiz(){
      this.currentItemKey = 0;
      this.wrongAnsweredIdArray = [];
      this.quizCompleted = false;
      this.previewItemMode = true;
      this.examItemMode = false;
      this.quizItemAnsweredId = null;
      this.timeLineProgress = null;
      this.quizItemAnswers = [];
      this.timeLineProgress = 0;
      this.quizItemAnswerTime = null;
      this.quizItemAnswerTotalTime = null;
      this.isAllowToAnswer = true;
    }

  },
}
</script>

<style scoped>
.memorize-item{
  padding: 5px 20px;
  border: 1px solid var(--text-primary);
  color: var(--text-primary);
  border-radius: 5px;
  margin: 0 2px;
}
.uk-modal-dialog{
  border-radius: 10px;
  overflow: hidden;
}
audio, audio:focus, audio:active{
  outline: none;
  box-shadow: none;
  border: none;
  width: 100% !important;
}
.answer-letter{
  background-color: var(--text-primary);
  display: block;
  width: 40px;
  height: 40px;
  vertical-align: middle;
  border-radius: 50%;
  font-size: 22px;
}

.answer:hover{
  cursor: pointer;
}
.answer-input{
  position: absolute;
  opacity: 0;
}
.answer-item{
  background-color: #F4F5F7;
  border: 1px solid #F4F5F7;
  border-radius: 10px;
  font-size: 16px
}
.answer-item:hover{
  cursor: pointer;
}
.answer-item.answered.correct{
  background-color: #FFFFFF;
  border: 1px solid #32d296;
  color: #32d296;
}
.answer-item.answered.incorrect{
  background-color: #FFFFFF;
  border: 1px solid #f0506e;
  color: #f0506e;
}
.answer-item.type-30{
  background-color: #F9F9FB;
  padding: 10px;
}
.status-icon{
  display: none;
  position: absolute;
  right: -15px;
  top: -15px;
}
.answer-item.answered .status-icon{
  display: flex;
}
.correct-answer-icon{
  color: #32d296;
  background-color: #DEF7EC;
}
.incorrect-answer-icon{
  color: #f0506e;
  background-color: #ffe8e8;
}
.disabled{
  pointer-events: none;
  cursor: not-allowed !important;
}
</style>