<template>
  <div>
    <div class="file-manager uk-grid-collapse uk-child-width-expand uk-padding-remove" uk-grid>
      <div>
        <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
          <div class="uk-grid-small uk-grid-match" uk-grid>
            <div class="uk-width-1-5">
              <div class="file-manager-sidebar" style="background-color: #F9F9FB; padding: 25px; height: 100%">
                <!--side bar-->
                <p class="uk-text-primary">{{ $t('main._home') }}</p>
                <ul class="uk-list">
                  <li class="nav-item"><a @click="goHome()"><span uk-icon="home"></span> Files</a></li>
                  <li class="nav-item"><a href=""><span uk-icon="cloud-upload"></span> Recently uploaded</a></li>
                </ul>
                <br>
                <p class="uk-text-primary">{{ $t('main.Folders') }}</p>
                <ul class="uk-list">
                  <li class="nav-item" v-for="folder in allFolders">
                    <a v-if="folder.sub_groups_count == 0"> <span><span uk-icon="folder"></span> <span v-html="folder.title"></span></span></a>
                    <ul v-else uk-accordion>
                      <li class="">
                        <a class="uk-accordion-title" href="#"><span uk-icon="folder"></span> <span v-html="folder.title"></span></a>
                        <div class="uk-accordion-content">
                          <ul class="uk-list">
                            <li class="nav-item"><a  @click="openFolder(folder)"><span uk-icon="folder"></span> <span v-html="folder.title"></span></a></li>
                            <li class="nav-item" v-for="subFolder in folder.sub_groups"><a @click="openFolder(subFolder)"><span uk-icon="folder"></span> <span v-html="subFolder.title"></span></a></li>
                          </ul>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <div class="uk-width-expand file-manager-content">
              <div class="bg-white">
                <!--toolbar-->
                <div class="file-manager-navbar">
                  <div class="uk-grid-small" style="padding: 16px 25px 25px 0" uk-grid>
                    <div class="uk-width-expand" style="padding-top: 10px">
                      <span @click="goHome()" class="hover-primary" uk-icon="icon: chevron-left"></span> <span v-html="groupName"></span> <span v-if="loadingMode" class="uk-text-primary"><span style="margin: 0 5px" uk-spinner="ratio: 0.5"></span> loading ...</span>
                    </div>
                    <div class="uk-width-auto">
                      <ul class="uk-list navbar-list">
                        <li><span @click="uploadMode = !uploadMode" :class="{'uk-text-primary':uploadMode}" class="navbar-item hover-primary" uk-icon="icon: cloud-upload" v-bind:uk-tooltip="$t('main.File upload')"></span></li>
                        <li><span @click="createFolder()" class="navbar-item hover-primary" uk-icon="icon: folder" v-bind:uk-tooltip="$t('main.New folder')"></span></li>
                        <li><span @click="putItemOnMove()" class="navbar-item hover-primary" uk-icon="icon: move" v-bind:uk-tooltip="$t('main.Move')"></span></li>
                        <li><span @click="pasteItem()" :class="{'uk-text-success bounce':onMoveItemId}" class="navbar-item hover-primary" uk-icon="icon: album" v-bind:uk-tooltip="$t('main.Paste')"></span></li>
<!--                        <li><span class="navbar-item hover-primary" uk-icon="icon: link" v-bind:uk-tooltip="$t('main.Copy link')"></span></li>-->
                        <li><span @click="destroyItem()"  class="navbar-item hover-danger" uk-icon="icon: trash" v-bind:uk-tooltip="$t('main.Delete')"></span></li>
                        <li><span @click="togglePreview()" class="navbar-item hover-primary" uk-icon="icon: info" v-bind:uk-tooltip="$t('main.Preview')"></span></li>
<!--                        <li>s</li>-->
                      </ul>
                    </div>

                  </div>
                </div>
                <!--files section-->
                <div class="uk-grid-collapse uk-grid-match" uk-grid style="padding: 20px 0px 20px 0 ">
                  <div class="uk-width-expand" style="padding-right: 10px; padding-bottom: 10px">
                    <div v-if="uploadMode" class="uk-margin">
                      <vue-dropzone id="dropzone"
                                    ref="myVueDropzone"
                                    @vdropzone-success="vSuccess"
                                    @vdropzone-total-upload-progress="vProgress"
                                    @vdropzone-sending="vSending"
                                    :options="dropzoneOptions" :useCustomSlot=true>
                        <div class="dropzone-custom-content">
                          <span class="uk-text-primary" uk-icon="icon: cloud-upload; ratio: 3.5"></span>
                          <p class="uk-text-muted uk-margin-remove">Drag and drop to upload content!</p>
                          <p class="uk-text-muted uk-margin-remove">Or click to select a file from your computer</p>
                        </div>
                      </vue-dropzone>
                    </div>
                    <div class="uk-grid-collapse uk-text-center" uk-grid="masonry: true">

                      <div :class="previewMode ? ' uk-width-1-4@l ' : 'uk-width-1-5@l '" v-for="folder in folders" class="uk-width-1-2@m">
                        <div :class="{active:activeFolderId == folder.id, onMove:onMoveItemId == folder.id}" class="folder" @dblclick="openFolder(folder)" @click="openFolderPreview(folder)">
                          <div class="image-wrapper">
                            <span class="uk-badge files-count" v-html="folder.items_count"></span>
                            <img data-src="/storage/assets/file_icons/folder.png" width="90" alt="" uk-img>
                          </div>
                          <div class="file-info uk-margin-small-top">
                            <p class="uk-margin-remove" v-html="folder.title"></p>
                            <p class="uk-margin-remove uk-text-muted folder-count">{{folder.sub_groups_count}} Folders</p>
                          </div>
                        </div>
                      </div>

                      <div :class="previewMode ? ' uk-width-1-4@l ' : 'uk-width-1-5@l '" v-for="file in files" class="uk-width-1-2@m">
                        <div :class="{active:activeFileId == file.id, onMove:onMoveItemId == file.id}" class="file image-file" @click="openFilePreview(file)">

                          <div class="image-wrapper">
                            <img :data-src="file.url" alt="" uk-img v-if="file.custom_properties.file_type === 'image'" class="img-preview">
                            <div v-else style="padding: 25px 10px 5px 10px">
                              <img class="uk-margin" :data-src="'/storage/assets/file_icons/'+file.custom_properties.extension+'.png'" alt="" width="60" uk-img>
                            </div>
                          </div>
                          <div class="file-info uk-margin-small-top">
                            <p class="uk-margin-remove" style=" word-wrap: break-word;" v-html="file.name"></p>
                            <p class="uk-margin-remove uk-text-muted" v-html="file.custom_properties.file_size_string"></p>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div v-if="previewMode" class="uk-width-1-3" style="background-color: #F9F9FB; padding: 10px;min-height: 72vh; display: block">
                    <!--file preview-->
                    <div v-if="previewFile != null" class="uk-grid-small uk-child-width-1-1@s" uk-grid>
                      <div class="uk-text-center" v-if="previewFile.custom_properties.file_type == 'image'">
                        <img :data-src="previewFile.url" alt="" uk-img style="border-radius: 10px; max-height: 300px; object-fit:cover">
                      </div>
                      <div v-else-if="previewFile.custom_properties.file_type == 'video'">
                        <video :src="previewFile.url" playsinline controls disablepictureinpicture controlsList="nodownload"></video>
                      </div>
                      <div v-else-if="previewFile.custom_properties.file_type == 'audio'">
                        <audio controls controlsList="nodownload">
                          <source :src="previewFile.url" type="audio/mpeg">
                        </audio>
                      </div>
                      <div>
                        <p class="uk-text-primary uk-margin-remove">{{ $t('main.File name') }}</p>
                        <input @change="updateFileTitle()" type="text" class="uk-input" v-model="previewFile.name">
                      </div>
                      <div>
                        <p class="uk-text-primary uk-margin-remove">{{ $t('main.Format') }}</p>
                        <p class="uk-margin-remove" v-html="previewFile.custom_properties.extension"></p>
                      </div>
                      <div>
                        <p class="uk-text-primary uk-margin-remove">{{$t('main.File size')}}</p>
                        <p class="uk-margin-remove" v-html="previewFile.custom_properties.file_size_string"></p>
                      </div>
                      <div>
                        <p class="uk-text-primary uk-margin-remove">{{$t('main.Created at')}}</p>
                        <p class="uk-margin-remove" v-html="previewFile.creation_date"></p>
                      </div>
                      <div>
                        <p class="uk-text-primary uk-margin-remove">{{$t('main.Url link')}}</p>
                        <div class="uk-grid-small uk-grid-match" uk-grid>
                          <div class="uk-width-expand">
                            <input type="text" class="uk-input preview-file-url" :value="previewFile.url" readonly>
                          </div>
                          <div class="uk-width-auto uk-fex uk-flex-middle">
                            <div><span @click="copyFileUrl()" class="navbar-item hover-primary" uk-icon="icon: link" v-bind:uk-tooltip="$t('main.Copy link')"></span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div v-else-if="previewFolder != null">
                      <div>
                        <p class="uk-text-primary uk-margin-remove" v-html="$t('main.Folder name')"></p>
                        <input @change="updateFolderTitle()" type="text" class="uk-input" v-model="previewFolder.title">
                      </div>
                      <div class="uk-margin-small">
                        <p class="uk-text-primary uk-margin-remove" v-html="$t('main.Files count')"></p>
                        <p class="uk-margin-remove" v-html="previewFolder.items_count + ' '+ $t('main.files')"></p>
                      </div>
                      <div class="uk-margin-small">
                        <p class="uk-text-primary uk-margin-remove" v-html="$t('main.Sub Folders count')"></p>
                        <p class="uk-margin-remove" v-html="previewFolder.sub_groups_count + ' '+ $t('main.folders')"></p>
                      </div>
                    </div>
                    <div v-else class="uk-text-center uk-text-muted">
                      <div style="padding-top: 40%">
                        <span uk-icon="icon: ban; ratio: 2"></span>
                        <p>No preview available</p>
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
// .....
const token = document.head.querySelector('meta[name="csrf-token"]').content
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
export default {
name: "FileManager",
  data(){
    return{
      dropzoneOptions: {
        url: '/manage/media',
        thumbnailWidth: 200,
        addRemoveLinks: true,
        // Setup chunking
        acceptedFiles: "image/*,video/*,audio/*",
        maxFiles: 5,
        timeout: 3600000,
        autoProcessQueue: true,
        chunking: true,
        maxFilesize: 400000000,
        chunkSize: 1000000,
        // If true, the individual chunks of a file are being uploaded simultaneously.
        parallelChunkUploads: false,
        headers: { 'X-CSRF-TOKEN': token },
      },
      loadingMode:false,
      previewMode:false,
      uploadMode:false,
      folders:[],
      allFolders:[],
      files:[],
      previewFile: null,
      previewFolder: null,
      items:null,
      currentGroup:null,
      groupSlug:null,
      groupName: 'Files',
      ancestor_slug: null,
      activeFileId: null,
      activeFolderId: null,
      activeItemType: null,
      activeItemTypeFile: 1, // file
      activeItemTypeFolder: 2, // group
      selectedItemType: null,
      onMoveItemId: null,
      onMoveItemType:null,
    }
  },
  created() {
    this.fetchFiles();
    this.fetchGroups();
  },
  methods: {
    togglePreview(){
      if (this.previewMode == true){
        this.activeFileId = null;
        this.previewFile = null;
      }
      this.previewMode = !this.previewMode;

    },
    fetchFiles(refreshPage = true){ // get all media files
      this.loadingMode = true;
      if (refreshPage){
        this.files = [];
      }
      axios.get('/manage/media/get/items', {
        params: {
          group: this.groupSlug,
        }
      })
      .then(res => {
        // console.log(res.data);
        this.files = res.data;
        this.hideLoading();
      })
      .catch(error => {
        console.log(error);
        this.hideLoading();
      });
    },
    fetchGroups(refreshPage = true){ // get all media groups
      if (refreshPage){
        this.folders = [];
      }
      this.loadingMode = true;
      axios.get('/manage/system/group/ajax/get/type/1/groups', {
        params: {
          ancestor_slug: this.groupSlug,
        }
      })
      .then(res => {
        this.folders = res.data;
        if (this.currentGroup == null){
          this.allFolders = res.data;
        }
        this.hideLoading();
      })
      .catch(error => {
        console.log(error);
        this.hideLoading();
      });
    },
    goHome(){
      this.uploadMode = false;
      this.currentGroup = null;
      this.groupSlug = null;
      this.groupName = 'Files';
      this.previewMode = false;
      this.previewFile = null;
      this.previewFolder = null;
      this.fetchFiles();
      this.fetchGroups();
    },
    openFilePreview(file){
      // this.previewMode = true;
      this.previewFolder = null;
      this.activeFolderId = null;
      this.previewFile = file;
      this.activeFileId = file.id;
      this.activeItemType = this.activeItemTypeFile;
      this.selectedItemType = this.activeItemTypeFile;
    },
    openFolderPreview(folder){
      // this.previewMode = true;
      this.previewFile = null;
      this.activeFileId = null;
      this.previewFolder = folder;
      this.activeFolderId = folder.id;
      this.activeItemType = this.activeItemTypeFolder;
      this.selectedItemType = this.activeItemTypeFolder;
    },
    openFolder(folder){
      this.uploadMode = false;
      this.previewFile = null;
      this.previewFolder = null;
      this.previewMode = false;
      this.activeFileId = null;
      this.currentGroup = folder;
      this.groupSlug = folder.slug;
      this.groupName = folder.title;
      this.fetchFiles();
      this.fetchGroups();
    },
    copyFileUrl(){
      var text = this.previewFile.url;
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val(text).select();
      document.execCommand("copy");
      $temp.remove();
      UIkit.notification("<span uk-icon='icon: check'></span> File url copied to clipboard.", {pos: 'top-center', status:'success'})

    },

    putItemOnMove(){
      this.onMoveItemId = this.onMoveItemType = null;
      this.onMoveItemType = this.activeItemType;
      if (this.activeFileId || this.activeFolderId){
        if (this.onMoveItemType === this.activeItemTypeFile){
          this.onMoveItemId = this.activeFileId;
        }else{
          this.onMoveItemId = this.activeFolderId;
        }
      }

    },
    pasteItem(){
      if (this.onMoveItemId){
        if (this.onMoveItemType === this.activeItemTypeFile){
          this.updateFile(this.onMoveItemId, null, this.groupSlug);
        }else{
          this.updateFolder(this.onMoveItemId, null, this.groupSlug );
        }
      }
    },
    destroyItem(){
        if (this.selectedItemType === this.activeItemTypeFile){
          this.destroyFile(this.activeFileId);
        }else if(this.selectedItemType === this.activeItemTypeFolder){
          // this.updateFolder(this.onMoveItemId, null, this.groupSlug );
          UIkit.notification("Group deleting is under development, please try again later.", {pos: 'top-center', status:'warning'})
        }
    },
    destroyFile(id){
      this.loadingMode = true;
      axios.post('/manage/media/ajax/delete/'+id)
          .then(res => {
            this.activeFileId = this.activeFile = null;
            this.previewMode = false;
            this.fetchFiles();
            this.hideLoading();
            // this.fetchGroups();
          })
          .catch(error => {
            console.log(error);
            this.hideLoading();
          });
    },
    updateFile(id, title ,groupSlug, refreshPage = true){
      this.loadingMode = true;
      const data = { id:id, title:title, group_slug:groupSlug };
      axios.post('/manage/media/ajax/move/item', data)
          .then(res => {
            this.onMoveItemId = this.onMoveItemType = null;
              this.fetchFiles(refreshPage);
            this.hideLoading();
          })
          .catch(error => {
            console.log(error);
            this.hideLoading();
          });
    },
    updateFolder(id, title ,ancestorId, refreshPage = true){
      this.loadingMode = true;
      const data = { id:id, title:title,  group_slug:ancestorId };
      axios.post('/manage/system/group/ajax/update', data)
          .then(res => {
            this.onMoveItemId = this.onMoveItemType = null;
              this.fetchGroups(refreshPage);
              this.fetchFiles(refreshPage);
            this.hideLoading();
          })
          .catch(error => {
            console.log(error);
            this.hideLoading();
          });
    },
    updateFolderTitle(){
      var previewTitle = this.previewFolder ? this.previewFolder.title : null;
      var previewId = this.previewFolder ? this.previewFolder.id : null;
      this.updateFolder(previewId, previewTitle, this.groupSlug, false);
    },
    updateFileTitle(){
      var previewTitle = this.previewFile ? this.previewFile.name : null;
      var previewId = this.previewFile ? this.previewFile.id : null;
      this.updateFile(previewId, previewTitle, this.groupSlug, false);
    },
    createFolder(){
      const data = {  title:'New folder', ancestor_slug:this.groupSlug };
      axios.post('/manage/system/group/ajax/create', data)
          .then(res => {
            // this.fetchFiles();
            this.fetchGroups(false);
            this.hideLoading();
          })
          .catch(error => {
            console.log(error);
            this.hideLoading();
          });
    },
    hideLoading(){
      setTimeout(()=>{
        this.loadingMode = false;
      },300
      );
    },
    // dropzone methods
    vSuccess(file, response) {
      console.log('success');
      this.fetchFiles(false);
      this.fetchGroups(false);
      // this.success = true
      // window.toastr.success('', 'Event : vdropzone-success')
      setTimeout(()=>{
        this.$refs.myVueDropzone.removeFile(file);
      },1500);
      UIkit.notification("<span uk-icon='icon: check'></span> File has uploaded successfully.", {pos: 'top-center', status:'success'})

    },
    vProgress(totalProgress, totalBytes, totalBytesSent) {
      // var progress = totalBytesSent / totalProgress.size * 100;
      // $('.dz-progress').width(progress + "%");
      // if (progress > 99.9){
      //   progress = 100
      // }
      console.log(totalProgress, totalBytes, totalBytesSent );
      // this.progress = true
      // this.myProgress = Math.floor(totalProgress)
      // // window.toastr.success('', 'Event : vdropzone-sending')

    },
    vSending(file, xhr, formData) {
      // this.sending = true
      // window.toastr.warning('', 'Event : vdropzone-sending');
      formData.append('group', this.groupSlug);
    },
  },
  components: {
    vueDropzone: vue2Dropzone
  },
}
</script>

<style scoped>
  .img-preview{
    max-height:150px;
    object-fit:cover;
  }
  .navbar-list li{
    display: inline-block;
  }
  .file-manager-content{
    min-height: 80vh;
  }
  .folder-count{
    font-size: 12px;
  }
  .files-count{
    position: absolute;
    margin-left: 70px;
    top: 70px;
    background-color: #32d296 !important;
    /*filter: drop-shadow(1px 1px 2px #969696);*/
  }
  .onMove{
    opacity: 0.5;
  }
  .bounce {
    animation: bounce 1s infinite;
  }

  @keyframes bounce {
    0%,
    25%,
    50%,
    75%,
    100% {
      transform: translateY(0);
    }
    40% {
      transform: translateY(-10px);
    }
    60% {
      transform: translateY(-6px);
    }
  }
  /*dropzone*/
  .dropzone-custom-content {
    text-align: center;
  }

  .vue-dropzone {
    text-align: center;
    border: 1px dotted #e5e5e5;
    color: #666666;
  }
  .vue-dropzone:hover {
   background-color: #F9F9FB;
  }

</style>