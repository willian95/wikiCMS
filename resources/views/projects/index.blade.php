@extends("layouts.main")

@section("content")

    <div class="d-flex flex-column-fluid" id="dev-projects">

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
                        <h3 class="card-label">Projects
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
                                <input type="text" class="form-control" v-model="query" @keyup="search()" placeholder="Title">
                            </div>
                        </div>
        
                    </div>

                    <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" id="kt_datatable" style="">
                        <table class="table">
                            <thead>
                                <tr >
                                    <th class="datatable-cell datatable-cell-sort" style="width: 170px;">
                                        <span>Title</span>
                                    </th>
                                    <th class="datatable-cell datatable-cell-sort" style="width: 170px;">
                                        <span>User</span>
                                    </th>
                                    <th class="datatable-cell datatable-cell-sort" style="width: 170px;">
                                        <span>Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="project in projects" v-if="project.titles.length > 0">
                                    <td class="datatable-cell">
                                        <span>@{{ project.titles[0].title }}</span>
                                    </td>
                                    <td class="datatable-cell">
                                        @{{ project.user.name }} @{{ project.user.lastname }}
                                    </td>
                                    <td>
                                        <a :href="'{{ env('WIKIFRONT_URL') }}'+'/project/show/'+project.id" class="btn btn-info"><i class="far fa-eye"></i></a>
                                        <button v-if="project.deleted_at == null" class="btn btn-secondary" @click="erase(project.id)"><i class="far fa-trash-alt"></i></button>
                                        <button v-else class="btn btn-success" @click="restore(project.id)"><i class="far fa-eye"></i></button>
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
                                            <a href="#" aria-controls="kt_datatable" data-dt-idx="1" tabindex="0" class="page-link">
                                                <i class="ki ki-arrow-back"></i>
                                            </a>
                                        </li>
                                        <li class="paginate_button page-item active" v-for="index in pages">
                                            <a href="#" aria-controls="kt_datatable" tabindex="0" class="page-link":key="index" @click="fetch(index)" >@{{ index }}</a>
                                        </li>
                                        
                                        <li class="paginate_button page-item next" id="kt_datatable_next" v-if="page < pages" href="#">
                                            <a href="#" aria-controls="kt_datatable" data-dt-idx="7" tabindex="0" class="page-link" @click="fetch(page + 6)">
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


    </div>

@endsection

@push("scripts")

    <script>
        
        const app = new Vue({
            el: '#dev-projects',
            data(){
                return{
                   
                    projects:[],
                    errors:[],
                    pages:0,
                    page:1,
                    showMenu:false,
                    loading:false,
                    query:""
                }
            },
            methods:{
                
                fetch(page = 1){

                    this.page = page

                    if(this.query == ""){

                        axios.get("{{ url('/projects/fetch/') }}"+"/"+page)
                        .then(res => {

                            this.projects = res.data.projects
                            this.pages = Math.ceil(res.data.projectsCount / res.data.dataAmount)

                        })

                    }else{

                        this.search()

                    }

                },
                erase(id){
                    
                    swal({
                        title: "Are you sure?",
                        text: "You will block this project!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            this.loading = true
                            axios.post("{{ url('/projects/delete/') }}", {id: id}).then(res => {
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
                    axios.post("{{ url('/projects/restore/') }}", {id: id}).then(res => {
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
                        
                        axios.post("{{ url('/projects/search') }}", {search: this.query, page: this.page}).then(res =>{

                            this.projects = res.data.projects
                            this.pages = Math.ceil(res.data.projectsCount / res.data.dataAmount)
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