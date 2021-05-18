@extends("layouts.main")

@section("content")

    <div class="d-flex flex-column-fluid" id="dev-users">

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
                        <h3 class="card-label">Users
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
                                        <a href="{{ url('/users/export/excel') }}" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="la la-file-excel-o"></i>
                                            </span>
                                            <span class="navi-text">Excel</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="{{ url('/users/export/csv') }}" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="la la-file-text-o"></i>
                                            </span>
                                            <span class="navi-text">CSV</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="{{ url('/users/export/pdf') }}" class="navi-link">
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
                                <input type="text" class="form-control" v-model="query" @keyup="search()" placeholder="Name or email">
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
                                        <span>Institution</span>
                                    </th>
                                    <th class="datatable-cell datatable-cell-sort" style="width: 170px;">
                                        <span>Role</span>
                                    </th>
                                    <th class="datatable-cell datatable-cell-sort" style="width: 170px;">
                                        <span>Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users">
                                    <td class="datatable-cell">
                                        @{{ user.name }} @{{ user.lastname }}
                                    </td>
                                    <td class="datatable-cell">
                                        @{{ user.institution ? user.institution.name : user.pending_institution_name }}
                                    </td>
                                    <td class="datatable-cell">
                                        <span v-if="user.role_id == 2">Teacher</span>
                                        <span v-if="user.role_id == 3">Institution admin</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-info" data-toggle="modal" data-target="#userModal" @click="edit(user)"><i class="far fa-edit"></i></button>
                                        <button v-if="user.deleted_at == null" class="btn btn-secondary" @click="erase(user.id)"><i class="far fa-trash-alt"></i></button>
                                        <button v-else class="btn btn-success" @click="restore(user.id)"><i class="far fa-eye"></i></button>
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
        <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                                <div class="col-md-6">
                                    <h4>Name:</h4>
                                    <p>@{{ name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h4>Institution:</h4>
                                    <p>@{{ institutionName }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h4>Email:</h4>
                                    <p>@{{ email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h4>Member since:</h4>
                                    <p>@{{ memberSince }}</p>
                                </div>
                                <div class="col-md-12">
                                    <div v-html="description"></div>
                                </div>
                                <div class="col-md-6">
                                    <h4>Country:</h4>
                                    <p>@{{ countryName }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h4>State:</h4>
                                    <p>@{{ stateName }}</p>
                                </div>
                                <div class="col-md-12">
                                    <h4>Cv resume:</h4>
                                    <p>
                                        <a :href="cvResume" target="_blank">@{{ cvResume }}</a>
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <h4>Portfolio:</h4>
                                    <p>
                                        <a :href="portfolio" target="_blank">@{{ portfolio }}</a>
                                    </p>
                                </div>
                            </div>


                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary font-weight-bold"  @click="update()" v-if="action == 'edit'">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push("scripts")

    <script>
        
        const app = new Vue({
            el: '#dev-users',
            data(){
                return{
                    modalTitle:"User information",

                    name:"",
                    userId:"",
                    email:"",
                    institutionName:"",
                    memberSince:"",
                    description:"",
                    countryName:"",
                    stateName:"",
                    cvResume:"",
                    portfolio:"",
                    
                    action:"create",
                    users:[],
                    errors:[],
                    pages:0,
                    page:1,
                    showMenu:false,
                    loading:false,
                    query:""
                }
            },
            methods:{
                
                edit(user){
                    this.modalTitle = "User information"
                    
                    if(user.institution){
                        this.institutionName = user.institution.name
                    }else{
                        this.institutionName = user.pending_institution_name
                    }
                     
                    this.name = user.name
                    this.email = user.email
                    this.memberSince = user.created_at
                
                    this.description = user.why_do_you_educate

                    if(user.country){
                        this.countryName = user.country.name
                    }
                    
                    if(user.state){
                        this.stateName = user.state.name
                    }
                    
                    this.cvResume = user.cv_resume
                    this.portfolio = user.portfolio


                },
                fetch(page = 1){

                    this.page = page

                    if(this.query == ""){

                        axios.get("{{ url('users/fetch') }}"+"/"+page)
                        .then(res => {

                            this.users = res.data.users
                            this.pages = Math.ceil(res.data.usersCount / res.data.dataAmount)

                        })

                    }else{

                        this.search()

                    }

                },
                erase(id){
                    
                    swal({
                        title: "Are you sure?",
                        text: "You will delete this user! You will have the option to activate this user as well.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            this.loading = true
                            axios.post("{{ url('/users/delete/') }}", {id: id}).then(res => {
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
                restore(id){
                    this.loading = true
                    axios.post("{{ url('/users/restore/') }}", {id: id}).then(res => {
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
                        
                        axios.post("{{ url('/users/search') }}", {search: this.query, page: this.page}).then(res =>{

                            this.users = res.data.users
                            this.pages = Math.ceil(res.data.usersCount / res.data.dataAmount)
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