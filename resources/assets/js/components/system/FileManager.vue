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
<!--                  <li class="nav-item"><a href=""><span uk-icon="cloud-upload"></span> Recently uploaded</a></li>-->
                </ul>
                <br>
                <p class="uk-text-primary">{{ $t('main.Folders') }}</p>
                <ul class="uk-list">
                  <li class="nav-item" v-for="folder in allFolders">
                    <a v-if="folder.sub_groups_count == 0" @click="openFolder(folder)"> <span><span uk-icon="folder"></span> <span v-html="folder.title"></span></span></a>
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
                      <input type="hidden" class="selected-file-url" v-model="previewFile.url" v-if="insertmode && previewFile">
                      <span @click="goPrev()" class="hover-primary" uk-icon="icon: chevron-left" v-bind:uk-tooltip="$t('main.Back')"></span> <span v-html="groupName"></span> <span v-if="loadingMode" class="uk-text-primary"><span style="margin: 0 5px" uk-spinner="ratio: 0.5"></span> {{$t('main.Loading')}}</span>
                    </div>
                    <div class="uk-width-auto disableSelection">
                      <ul class="uk-list navbar-list">
                        <li><span @click="uploadMode = !uploadMode" :class="{'uk-text-primary':uploadMode}" class="navbar-item hover-primary" uk-icon="icon: cloud-upload" v-bind:uk-tooltip="$t('main.File upload')"></span></li>
                        <li><span @click="createFolder()" class="navbar-item hover-primary" uk-icon="icon: folder" v-bind:uk-tooltip="$t('main.New folder')"></span></li>
                        <li><span @click="putItemOnMove()" class="navbar-item hover-primary" uk-icon="icon: move" v-bind:uk-tooltip="$t('main.Move')"></span></li>
                        <li><span @click="pasteItem()" :class="{'uk-text-success bounce':onMoveItemId}" class="navbar-item hover-primary" uk-icon="icon: album" v-bind:uk-tooltip="$t('main.Paste')"></span></li>
<!--                        <li><span class="navbar-item hover-primary" uk-icon="icon: link" v-bind:uk-tooltip="$t('main.Copy link')"></span></li>-->
                        <li><span @click="destroyItem()"  class="navbar-item hover-danger" uk-icon="icon: trash" v-bind:uk-tooltip="$t('main.Delete')"></span></li>
                        <li><span @click="togglePreview()" class="navbar-item hover-primary" uk-icon="icon: info" v-bind:uk-tooltip="$t('main.Preview')"></span></li>
                        <li v-if="insertmode">
                          <button @click="resetSelectedPreview()" class="uk-button uk-button-primary insert-selected-media-file" v-bind:disabled="activeFileId == null ? true: false" v-html="$t('main.Insert')"></button>
                        </li>
                      </ul>
                    </div>

                  </div>
                </div>
                <!--files section-->
                <div class="uk-grid-collapse uk-grid-match" uk-grid style="height: 100%; padding: 20px 0px 20px 0 ">
                  <div class="uk-width-expand" style="padding-right: 10px; padding-bottom: 10px">
                    <!-- upload-->
                    <div v-if="uploadMode" class="uk-margin">
                      <vue-dropzone id="dropzone"
                                    ref="myVueDropzone"
                                    @vdropzone-success="vSuccess"
                                    @vdropzone-total-upload-progress="vProgress"
                                    @vdropzone-sending="vSending"
                                    :options="dropzoneOptions" :useCustomSlot=true>
                        <div class="dropzone-custom-content">
                          <span class="uk-text-primary" uk-icon="icon: cloud-upload; ratio: 3.5"></span>
                          <p class="uk-text-muted uk-margin-remove" v-html="$t('main.Drag and drop message')"></p>
                          <p class="uk-text-muted uk-margin-remove" v-html="$t('main.you are allowed to upload message')"></p>
                        </div>
                      </vue-dropzone>
                    </div>
                    <div class="uk-grid-collapse uk-text-center" uk-grid="masonry: true" @drop.prevent="onDrop()" >
                      <!-- Folder -->
                      <div :class="previewMode ? ' uk-width-1-4@l ' : 'uk-width-1-5@l '" v-for="folder in folders" class="uk-width-1-2@m" draggable @dragstart="startFolderDrag(folder)" @dragover.prevent="onDragHoverFolder(folder)">
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
                      <!-- File -->
                      <div :class="previewMode ? ' uk-width-1-4@l ' : 'uk-width-1-5@l '" v-for="file in files" class="uk-width-1-2@m" @click="openFilePreview(file)" draggable @dragstart="startFileDrag(file)">
                        <div :class="{active:activeFileId == file.id, onMove:onMoveItemId == file.id}" class="file image-file">
                          <span v-if="insertmode && activeFileId == file.id" class="uk-icon-button selected-file-badge" uk-icon="check"></span>
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
                    <!--no items-->
                    <div v-if="files.length < 1 && folders.length < 1 && !uploadMode" class="uk-padding-large uk-text-center uk-text-muted uk-flex uk-flex-middle uk-flex-center"  style="height: 60vh;">
                      <div v-if="!loadingMode">
                        <img class="no-media-icon" data-src="/storage/assets/file_icons/folder.png" width="90" alt="" uk-img>
                        <p v-html="$t('main.There is no media items available yet')"></p>
                      </div>
                      <div v-else>
                        <div class="uk-text-primary">
                          <span uk-spinner="ratio: 2.5"></span>
                          <div class="uk-margin-small">
                            <p>{{$t('main.Loading')}}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!--file preview-->
                  <div v-if="previewMode" class="uk-width-1-3" style="background-color: #F9F9FB; padding: 10px;min-height: 72vh; display: block">
                    <div v-if="previewFile != null" class="uk-grid-small uk-child-width-1-1@s" uk-grid>
                      <div class="uk-text-center" v-if="previewFile.custom_properties.file_type === 'image'">
                        <div uk-lightbox>
                          <a :href="previewFile.url"><img :data-src="previewFile.url" alt="" uk-img style="border-radius: 10px; max-height: 300px; object-fit:cover"></a>
                        </div>
                      </div>
                      <div v-else-if="previewFile.custom_properties.file_type == 'video'">
                        <video :src="previewFile.url" playsinline controls disablepictureinpicture controlsList="nodownload"></video>
                      </div>
                      <div v-else-if="previewFile.custom_properties.file_type === 'audio'">
                        <audio :src="previewFile.url" controls controlsList="nodownload">
                          <source type="audio/mpeg">
                        </audio>
                      </div>
                      <div v-else-if="previewFile.custom_properties.file_type === 'application'">
                        <div v-if="previewFile.custom_properties.extension === 'pdf'">
                          <embed :src="previewFile.url" />
                          <div class="uk-margin-small uk-text-center">
                            <a class="uk-button uk-button-default" target="_blank" :href="previewFile.url" v-html="$t('main.view')">
                            </a>
                          </div>
                        </div>
                        <div v-else class="uk-padding-small uk-text-center">
                          <img class="uk-margin" :data-src="'/storage/assets/file_icons/'+previewFile.custom_properties.extension+'.png'" alt="" width="75" uk-img>
                          <div class="uk-margin-small uk-text-center">
                            <a class="uk-button uk-button-default" target="_blank" :href="previewFile.url" >
                              <span uk-icon="icon: download"></span>
                              <span v-html="$t('main.Download')"></span>
                            </a>
                          </div>
                        </div>
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
  props: [
    'insertmode'
  ],
  data(){
    return{
      dropzoneOptions: {
        url: '/manage/media',
        thumbnailWidth: 200,
        addRemoveLinks: true,
        // Setup chunking
        acceptedFiles: "image/*, video/*, audio/*, application/pdf, .rar, .zip, .docx, .doc, .pptx, .ppt, .xlsx, .xls",
        maxFiles: 10,
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
      prevGroup:null,
      prevGroupName:'Files',
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
      // dragging
      draggedFile:null,
      draggedFileId:null,
      draggedHoverFolderSlug:null,
      draggedItemType:null,
      draggedFolderId:null,

    }
  },
  created() {
    this.fetchFiles();
    this.fetchGroups();
  },
  methods: {

    startFileDrag(file) {
      this.draggedFileId = file.id;
      this.draggedHoverFolderSlug = this.draggedFolderId = null;
      this.draggedItemType = this.activeItemTypeFile;
    },
    startFolderDrag(folder) {
      this.draggedFolderId = folder.id;
      this.draggedHoverFolderSlug = this.draggedFileId = null;
      this.draggedItemType = this.activeItemTypeFolder;
    },
    onDragHoverFolder(folder) {
      this.draggedHoverFolderSlug = folder.slug;
    },
    onDrop(){
      this.dropItem();
    },
    dropItem(){
      if (this.draggedHoverFolderSlug){
        if (this.draggedFileId && this.draggedItemType == this.activeItemTypeFile){
          this.updateFile(this.draggedFileId, null, this.draggedHoverFolderSlug, false);
          this.draggedFileId = null;
          this.draggedHoverFolderSlug = null;
          this.draggedItemType = null;
        }
        if (this.draggedFolderId && this.draggedItemType == this.activeItemTypeFolder){
          this.updateFolder(this.draggedFolderId, null, this.draggedHoverFolderSlug, false);
        }
      }
    },
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
        console.log(this.files)
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
          parent_slug: this.groupSlug,
        }
      })
      .then(res => {
        this.folders = res.data.groups;
        if (this.currentGroup == null){
          this.allFolders = res.data.groups;
        }
        this.prevGroup = res.data.prevGroup.slug;
        this.prevGroupName = res.data.prevGroup.title;
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
    goPrev(){
      if (this.prevGroup == null){
        this.goHome();
      }else{
        this.groupSlug = this.prevGroup;
        this.groupName = this.prevGroupName;
        this.fetchFiles();
        this.fetchGroups();
      }
    },
    openFilePreview(file){
      // this.previewMode = true;
      this.previewFolder = null;
      this.activeFolderId = null;
      this.previewFile = file;
      this.activeFileId = file.id;
      this.activeItemType = this.activeItemTypeFile;
      this.selectedItemType = this.activeItemTypeFile;
      console.log('prev',this.previewFile);

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
      this.prevGroup = this.groupSlug;
      this.prevGroupName = this.groupName;
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
          this.updateFile(this.onMoveItemId, null, this.groupSlug, false);
          this.previewFile = null;
          this.activeFileId = null;
        }else{
          this.updateFolder(this.onMoveItemId, null, this.groupSlug, false);
        }
      }
    },
    destroyItem(){
        if (this.selectedItemType === this.activeItemTypeFile){
          if (!confirm('Are you sure that you want to delete this file?')){
            return false;
          }
          this.destroyFile(this.activeFileId);
        }else if(this.selectedItemType === this.activeItemTypeFolder){
          if (!confirm('Are you sure that you want to delete this folder?')){
            return false;
          }
          this.destroyFolder(this.activeFolderId);
        }
    },
    destroyFile(id){
      this.loadingMode = true;
      var files = this.files;
      var removedItemId = id;
      $.each( files, function( key, file ) {
        if (file && file.id && file.id == removedItemId){
          files.splice(key, 1);
        }
      });
      this.files = files;
      axios.post('/manage/media/ajax/delete/'+id)
        .then(res => {
          if (res.status != 200){
            UIkit.notification("<span uk-icon='icon: ban'></span> An error with status "+res.status+" accrued!", {pos: 'top-center', status:'danger'})
          }
          this.activeFileId = this.activeFile = null;
          this.previewMode = false;
          // this.fetchFiles(false);
          this.hideLoading();
          // this.fetchGroups();
        })
        .catch(error => {
          console.log(error);
          this.hideLoading();
        });
    },
    destroyFolder(id){
      this.loadingMode = true;
      var folders = this.folders;
      var removedItemId = id;
      $.each( folders, function( key, folder ) {
        if (folder && folder != undefined && folder.id && folder.id == removedItemId){
          folders.splice(key, 1);
        }
      });
      this.folders = folders;
      axios.post('/manage/system/group/'+id+'/ajax/destroy/type/1')
          .then(res => {
            if (res.status != 200){
              UIkit.notification("<span uk-icon='icon: ban'></span> An error with status "+res.status+" accrued!", {pos: 'top-center', status:'danger'})
            }
            this.activeFileId = this.activeFile = null;
            this.previewMode = false;
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
            if (res.status != 200){
              UIkit.notification("<span uk-icon='icon: ban'></span> An error with status "+res.status+" accrued!", {pos: 'top-center', status:'danger'})
            }
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
    updateFolder(id, title ,ancestorId, refreshPage = true){
      console.log(ancestorId)
      this.loadingMode = true;
      const data = { id:id, title:title,  group_slug:ancestorId };
      axios.post('/manage/system/group/ajax/update', data)
          .then(res => {
            if (res.status != 200){
              UIkit.notification("<span uk-icon='icon: ban'></span> An error with status "+res.status+" accrued!", {pos: 'top-center', status:'danger'})
            }
            this.onMoveItemId = this.onMoveItemType = null;
            this.fetchGroups(refreshPage);
            this.fetchFiles(refreshPage);
            this.hideLoading();
          })
          .catch(error => {
            UIkit.notification("<span uk-icon='icon: ban'></span> "+error, {pos: 'top-center', status:'danger'})
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
      const data = {  title:'New folder', parent_slug:this.groupSlug };
      axios.post('/manage/system/group/ajax/create', data)
          .then(res => {
            if (res.status != 200){
              UIkit.notification("<span uk-icon='icon: ban'></span> An error with status "+res.status+" accrued!", {pos: 'top-center', status:'danger'})
            }
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
    resetSelectedPreview(){
      this.activeFileId = null;
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
      },2000);
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
  audio, audio:focus, audio:active{
    outline: none;
    box-shadow: none;
    border: none;
    width: 100% !important;
  }
  audio:focus, audio:active{
    /*filter: drop-shadow(1px 5px 5px #F2F4F8);*/
  }
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
  .selected-file-badge{
    position: absolute;
    right: -9px;
    top: -9px;
    background-color: #32d296 !important;
    color: white;
    z-index: 999;
    /*filter: drop-shadow(1px 1px 2px #969696);*/
  }

  .onMove{
    opacity: 0.5;
  }
  .bounce {
    animation: bounce 1s infinite;
  }
  .no-media-icon{
    opacity: 0.3;
    filter: grayscale(90%);
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
    font-family: 'Cairo', 'Rubik', sans-serif !important;
  }

  .vue-dropzone {
    text-align: center;
    border: 1px dotted #e5e5e5;
    color: #666666;
  }
  .vue-dropzone:hover {
   background-color: #F9F9FB;
  }
  .disableSelection{
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    outline: 0;
  }

</style>