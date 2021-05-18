@extends("layouts.main")

@section("content")

    <div class="d-flex flex-column-fluid" id="dev-institutions">

        <div class="loader-cover-custom" v-if="loading == true">
			<div class="loader-custom"></div>
		</div>

        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <!--begin::Header-->
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Institutions
                    </div>
                    <div class="card-toolbar">

                        <!--begin::Dropdown-->
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @click="toggleMenu()">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3"></path>
                                        <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000"></path>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>Export</button>
                            <!--begin::Dropdown Menu-->
                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" id="menu">
                                <!--begin::Navigation-->
                                <ul class="navi flex-column navi-hover py-2">
                                    <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Choose:</li>
                                    
                                    <li class="navi-item">
                                        <a href="{{ url('/institution/export/excel') }}" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="la la-file-excel-o"></i>
                                            </span>
                                            <span class="navi-text">Excel</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="{{ url('/institution/export/csv') }}" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="la la-file-text-o"></i>
                                            </span>
                                            <span class="navi-text">CSV</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="{{ url('/institution/export/pdf') }}" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="la la-file-text-o"></i>
                                            </span>
                                            <span class="navi-text">PDF</span>
                                        </a>
                                    </li>
                                    
                                </ul>
                                <!--end::Navigation-->
                            </div>
                            <!--end::Dropdown Menu-->
                        </div>
                        <!--end::Dropdown-->

                        <!--begin::Button-->
                        <button href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#institutionModal" @click="create()">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                    <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>New Institution</button>
                        <!--end::Button-->
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin: Datatable-->

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Search</label>
                                <input type="text" class="form-control" v-model="query" @keyup="search()" placeholder="Institution">
                            </div>
                        </div>
        
                    </div>

                    <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" id="kt_datatable" style="">
                        <table class="table">
                            <thead>
                                <tr >
                                    <th class="datatable-cell datatable-cell-sort" style="width: 170px;">
                                        <span>Name</span>
                                    </th>
                                    <th class="datatable-cell datatable-cell-sort" style="width: 170px;">
                                        <span>Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="institution in institutions">
                                    <td class="datatable-cell">
                                        @{{ institution.name }}
                                    </td>
                                    <td>
                                        <button class="btn btn-info" data-toggle="modal" data-target="#institutionModal" @click="edit(institution)"><i class="far fa-edit"></i></button>
                                        <button class="btn btn-secondary" @click="erase(institution.id)"><i class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="kt_datatable_info" role="status" aria-live="polite">Showing page @{{ page }} of @{{ pages }}</div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_full_numbers" id="kt_datatable_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button page-item previous disabled" id="kt_datatable_previous" v-if="page > 1">
                                            <a style="cursor:pointer" aria-controls="kt_datatable" data-dt-idx="1" tabindex="0" class="page-link">
                                                <i class="ki ki-arrow-back"></i>
                                            </a>
                                        </li>
                                        <li class="paginate_button page-item active" v-for="index in pages">
                                            <a style="cursor:pointer" aria-controls="kt_datatable" tabindex="0" class="page-link":key="index" @click="fetch(index)" >@{{ index }}</a>
                                        </li>
                                        
                                        <li class="paginate_button page-item next" id="kt_datatable_next" v-if="page < pages">
                                            <a style="cursor:pointer" aria-controls="kt_datatable" data-dt-idx="7" tabindex="0" class="page-link" @click="fetch(page + 6)">
                                                <i class="ki ki-arrow-next"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Datatable-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->

        <!-- Modal-->
        <div class="modal fade" id="institutionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@{{ modalTitle }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" v-model="name" id="name">
                                        <small style="color: red;" v-if="errors.hasOwnProperty('name')">@{{ errors['name'][0] }}</small>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="website">Website</label>
                                        <input type="text" class="form-control" v-model="website" id="website">
                                        <small style="color: red;" v-if="errors.hasOwnProperty('website')">@{{ errors['website'][0] }}</small>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select class="form-control" v-model="type">
                                            <option value="school">School</option>
                                            <option value="university">University</option>
                                            <option value="organization">Organization</option>
                                        </select>
                                        <small style="color: red;" v-if="errors.hasOwnProperty('type')">@{{ errors['type'][0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4 class="text-center">Administrators</h4>  
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="adminName">Name</label>
                                        <input type="text" class="form-control" v-model="adminName" id="adminName">
                                        <small style="color: red;" v-if="errors.hasOwnProperty('adminName')">@{{ errors['adminName'][0] }}</small>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="adminEmail">Email</label>
                                        <input type="email" class="form-control" v-model="adminEmail" id="adminEmail">
                                        <small style="color: red;" v-if="errors.hasOwnProperty('adminEmail')">@{{ errors['adminEmail'][0] }}</small>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="adminPassword">Password</label>
                                        <input type="password" class="form-control" v-model="adminPassword" id="adminPassword">
                                        <small style="color: red;" v-if="errors.hasOwnProperty('adminPassword')">@{{ errors['adminPassword'][0] }}</small>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="adminName2">Name</label>
                                        <input type="text" class="form-control" v-model="adminName2" id="adminName2">
                                        <small style="color: red;" v-if="errors.hasOwnProperty('adminName2')">@{{ errors['adminName2'][0] }}</small>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="adminEmail2">Email</label>
                                        <input type="email" class="form-control" id="adminEmail2" v-model="adminEmail2">
                                        <small style="color: red;" v-if="errors.hasOwnProperty('adminEmail2')">@{{ errors['adminEmail2'][0] }}</small>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="adminPassword2">Password</label>
                                        <input type="password" class="form-control" id="adminPassword2" v-model="adminPassword2">
                                        <small style="color: red;" v-if="errors.hasOwnProperty('adminPassword2')">@{{ errors['adminPassword2'][0] }}</small>
                                    </div>
                                </div>
                                {{--<div class="col-lg-6" v-if="action == 'edit'">
                                    <label>Status: @{{ status }}</label>

                                    <button class="btn btn-success" @click="changeStatus('approved')">Approve</button>
                                    <button class="btn btn-danger" @click="changeStatus('rejected')">Reject</button>

                                </div>--}}
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary font-weight-bold"  @click="store()" v-if="action == 'create'">Create</button>
                        <button type="button" class="btn btn-primary font-weight-bold"  @click="update()" v-if="action == 'edit'">Update</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push("scripts")

    <script>
        
        const app = new Vue({
            el: '#dev-institutions',
            data(){
                return{
                    modalTitle:"New institution",
                    name:"",
                    type:"school",
                    website:"",
                    institutionId:"",
                    action:"create",
                    institutions:[],
                    adminId:"",
                    adminId2:"",
                    adminName:"",
                    adminEmail:"",
                    adminPassword:"",
                    adminName2:"",
                    adminEmail2:"",
                    adminPassword2:"",
                    errors:[],
                    pages:0,
                    page:1,
                    showMenu:false,
                    loading:false,
                    query:"",
                }
            },
            methods:{
                
                create(){
                    this.action = "create"
                    this.name = ""
                    this.institutionId = ""
                    this.adminName=""
                    this.adminEmail=""
                    this.adminPassword =""
                    this.adminName2=""
                    this.adminEmail2=""
                    this.adminPassword2 =""
                    this.adminId=""
                    this.adminId2=""
                },
                store(){

                    this.errors = []
                    this.loading = true

                    axios.post("{{ url('institution/store') }}", {name: this.name, adminName: this.adminName, adminEmail: this.adminEmail, adminPassword: this.adminPassword, adminName2: this.adminName2, adminPassword2: this.adminPassword2, adminEmail2: this.adminEmail2, type: this.type, website: this.website, domain: this.domain})
                    .then(res => {
                        this.loading = false
                        if(res.data.success == true){

                            swal({
                                text: res.data.msg,
                                icon: "success"
                            });
                            
                            this.clearInputs()


                            this.fetch()
                        }else{

                            swal({
                                text: res.data.msg,
                                icon: "error"
                            });

                        }

                    })
                    .catch(err => {

                        swal({
                            text: "Check some fields, please",
                            icon: "error"
                        });

                        this.loading = false
                        this.errors = err.response.data.errors
                    })

                },
                update(){

                    this.loading = true
                    axios.post("{{ url('institution/update') }}", {id: this.institutionId, name: this.name, adminName: this.adminName, adminEmail: this.adminEmail, adminPassword: this.adminPassword, adminName2: this.adminName2, adminPassword2: this.adminPassword2, adminEmail2: this.adminEmail2, type: this.type, website: this.website, domain: this.domain, adminId: this.adminId, adminId2: this.adminId2})
                    .then(res => {
                        this.loading = false
                        if(res.data.success == true){

                            swal({
                                text: res.data.msg,
                                icon: "success"
                            });
                            this.clearInputs()
                            this.fetch()
                            
                        }else{

                            swal({
                                text: res.data.msg,
                                icon: "error"
                            });

                        }

                    })
                    .catch(err => {

                        swal({
                            text: "Check some fields, please",
                            icon: "error"
                        });

                        this.loading = false
                        this.errors = err.response.data.errors
                    })


                },
                clearInputs(){
                    this.name = ""
                    this.institutionId = ""
                    this.adminName=""
                    this.adminEmail=""
                    this.adminPassword =""
                    this.adminName2=""
                    this.adminEmail2=""
                    this.adminPassword2 =""
                    this.finalPictureName=""
                    this.type = ""
                    this.webiste = ""
                    this.domain = ""
                    this.adminId=""
                    this.adminId2=""
                },
                edit(institution){
                    this.modalTitle = "Edit institution"
                    this.action = "edit"
                    
                    this.name = institution.name
                    this.institutionId = institution.id
                    this.type = institution.type
                    this.website = institution.website

                    this.adminId=institution.users[0].id
                    this.adminName=institution.users[0].name
                    this.adminEmail=institution.users[0].email
                    this.adminPassword = ""

                    this.adminId2=institution.users[1].id
                    this.adminName2= institution.users[1].name
                    this.adminEmail2=institution.users[1].email
                    this.adminPassword2 = ""


                },
                fetch(page = 1){

                    this.page = page

                    if(this.query == ""){

                        axios.get("{{ url('institution/fetch') }}"+"/"+page)
                        .then(res => {

                            this.institutions = res.data.institutions
                            this.pages = Math.ceil(res.data.institutionsCount / res.data.dataAmount)

                        })
                    }else{
                        this.search()
                    }

                },
                erase(id){
                    
                    swal({
                        title: "Are you sure?",
                        text: "You will delete this institution!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            this.loading = true
                            axios.post("{{ url('/institution/delete/') }}", {id: id}).then(res => {
                                this.loading = false
                                if(res.data.success == true){
                                    swal({
                                        text: res.data.msg,
                                        icon: "success"
                                    });
                                    this.fetch()
                                }else{

                                    swal({
                                        text: res.data.msg,
                                        icon: "error"
                                    });

                                }

                            }).catch(err => {
                                this.loading = false
                                
                            })

                        }
                    });

                },
                toggleMenu(){

                    if(this.showMenu == false){
                        $("#menu").addClass("show")
                        this.showMenu = true
                    }else{
                        $("#menu").removeClass("show")
                        this.showMenu = false
                    }

                },
                search(){
                    
                    if(this.query == ""){
                        
                        this.fetch()

                    }else{
                        
                        axios.post("{{ url('/institution/search') }}", {search: this.query, page: this.page}).then(res =>{

                            this.institutions = res.data.institutions
                            this.pages = Math.ceil(res.data.institutionsCount / res.data.dataAmount)
                            //this.setCheckbox()
                        })

                    }

                },
                changeStatus(status){
                    this.loading = true
                    axios.post("{{ url('/institution/change-status') }}", {id: this.institutionId, status: status}).then(res => {

                        this.loading = false
                        if(res.data.success == true){
                            this.status = res.data.status
                            swal({
                                text: res.data.msg,
                                icon: "success"
                            });
                            this.fetch()

                        }else{
                            
                            swal({
                                text: res.data.msg,
                                icon: "error"
                            });

                        }

                    }).catch(err => {
                        this.loading = false
                    })

                }


            },
            mounted(){
                
                this.fetch()

            }

        })
    
    </script>

@endpush