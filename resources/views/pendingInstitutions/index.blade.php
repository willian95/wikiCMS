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
                        <h3 class="card-label">Pending Institutions
                    </div>
                    <div class="card-toolbar">


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
                                        <span>Website</span>
                                    </th>
                                    <th class="datatable-cell datatable-cell-sort" style="width: 170px;">
                                        <span>Email</span>
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
                                    <td class="datatable-cell">
                                        @{{ institution.website }}
                                    </td>
                                    <td class="datatable-cell">
                                        @{{ institution.email }}
                                    </td>
                                    <td>
                                        <button class="btn btn-info" data-toggle="modal" data-target="#institutionModal" @click="edit(institution)">approve</button>
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
                                        
                                        <li class="paginate_button page-item next" id="kt_datatable_next" v-if="page < pages" href="#">
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
                                    <h4 class="text-center">Administrator</h4>  
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
                                
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary font-weight-bold"  @click="approve()" v-if="action == 'create'">Create</button>
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
                    modalTitle:"Institution info",
                    pendingInstitutionId:"",
                    name:"",
                    type:"school",
                    website:"",
                    institutionId:"",
                    action:"create",
                    institutions:[],
                    adminName:"",
                    adminEmail:"",
                    adminPassword:"",
                    errors:[],
                    pages:0,
                    page:1,
                    showMenu:false,
                    loading:false,
                    query:"",
                }
            },
            methods:{
                
                approve(){

                    this.loading = true
                    axios.post("{{ url('/pending-institution/approve') }}", {name: this.name, adminName: this.adminName, adminEmail: this.adminEmail, adminPassword: this.adminPassword, type: this.type, website: this.website, pendingInstitution: this.pendingInstitutionId}).then(res => {

                        this.loading = false
                        if(res.data.success == true){

                            swal({
                                text: res.data.msg,
                                icon: "success"
                            });

                            $("#institutionModal").modal('hide')
                            $('.modal-backdrop').remove();

                            this.fetch()

                        }else{

                            swal({
                                text: res.data.msg,
                                icon: "error"
                            });

                        }


                    })
                    .catch(err => {
                        this.loading = false
                        this.errors = err.response.data.errors
                        swal({
                            text: "Check some fields, please",
                            icon: "error"
                        });

                        
                        
                    })

                },
                edit(institution){

                    this.pendingInstitutionId = institution.id
                    this.name = institution.name
                    this.website = institution.website

                    this.adminName=""
                    this.adminEmail=""
                    this.adminPassword = ""


                },
                fetch(page = 1){

                    this.page = page

                    if(this.query == ""){

                        axios.get("{{ url('pending-institution/fetch') }}"+"/"+page)
                        .then(res => {

                            this.institutions = res.data.pendingInstitutions
                            this.pages = Math.ceil(res.data.pendingInstitutionsCount / res.data.dataAmount)

                        })
                    }else{
                        this.search()
                    }

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
                        
                        axios.post("{{ url('/pending-institution/search') }}", {search: this.query, page: this.page}).then(res =>{

                            this.institutions = res.data.pendingInstitutions
                            this.pages = Math.ceil(res.data.pendingInstitutionsCount / res.data.dataAmount)
                            //this.setCheckbox()
                        })

                    }

                }


            },
            mounted(){
                
                this.fetch()

            }

        })
    
    </script>

@endpush