@extends("layouts.profile")

@section("content")

    <div class="container" id="institutionProfile">

        <div class="loader-cover-custom" v-if="loading == true">
            <div class="loader-custom"></div>
        </div>

        <p class="text-center">
            <button class="btn btn-success" @click="unban()">Unban</button>
        </p>  


        <div class="main-profile">


            <div class="row main-dates">
                <div class="col-md-4">
                    <p>Registered Educators:</p>
                    <span>@{{ registeredEducatorsCount }}</span>

                </div>
                <div class="col-md-4">
                    <p>WikiPBL Pages (public):</p>
                    <span>@{{ publicPBLCounts }}</span>
                </div>
                <div class="col-md-4">
                    <p> Private wikiPBL Pages:</p>
                    <span>@{{ privatePBLCounts }}</span>
                </div>
            </div>

            <div class="main-profile_dates">
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <p><strong> Name:</strong>@{{ institutionName }} </p>
                            <p><strong>Member since:</strong> @{{ memberSince }}</p>
                            <p><strong> Country:</strong> @{{ country }}</p>
                            <p><strong>City:</strong> @{{ state }}</p>
                            <p><strong>Lowest Age:</strong>@{{ lowestAge }}</p>
                            <p><strong>Highest Age:</strong>@{{ highestAge }}</p>
                            <p v-if="type == 'school' || type == 'university'"><strong> Type:</strong> @{{ genderType }}</p>
                            <p><strong>Type:</strong>@{{ privateOrPublicInstitution }}</p>
                            <p v-if="type == 'school' || type == 'university'"><strong>PBL Network:</strong> @{{ whichNetwork }}</p>
                            <p v-if="type == 'school' || type == 'university'"><strong> # students enrolled:</strong>@{{ studentsEnrolled }}</p>
                            <p v-if="type == 'school' || type == 'university'"><strong> # faculty members:</strong>@{{ facultyMembers }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div v-for="user in users">
                            <h3> Created by</h3>
                            <p><strong> Name:</strong>@{{ user.name }} @{{ user.lastname }}</p>
                            <p><strong> Email:</strong>@{{ user.email }}</p>

                        </div>
                        

                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@push("scripts")

    <script>

        const institutionProfile = new Vue({
            el: '#institutionProfile',
            data() {
                return{

                    registeredEducatorsCount:0,
                    publicPBLCounts:0,
                    privatePBLCounts:0,
                    loading:false,
                    institutionId:"{{ $institution->id }}",
                    type:"{{ $institution->type }}",
                    institutionName:"{{ $institution->name }}",
                    memberSince:"{{ $institution->created_at->format('m/d/Y') }}",
                    country:"{{ $institution->country ? strip_tags($institution->country->name) : '' }}",
                    state:"{{ $institution->state ? strip_tags($institution->state->name) : '' }}",
                    lowestAge:"{{ $institution->lowest_age }}",
                    highestAge:"{{ $institution->highest_age }}",
                    genderType:"{{ $institution->gender_institution_type }}",
                    privateOrPublicInstitution:"{{ $institution->institution_public_or_private }}",
                    studentsEnrolled:"{{ $institution->students_enrolled }}",
                    facultyMembers:"{{ $institution->faculty_members }}",
                    whichNetwork:"{{ strip_tags($institution->which_network) }}",
                    report:"{{ \Auth::check() ? App\InstitutionReport::where('user_id', \Auth::user()->id)->where('institution_id', $institution->id)->count() : 0 }}",
                    modalField:"",
                    userName:"",
                    userLastname:"",
                    userPassword:"",
                    userPasswordConfirmation:"",
                    userPhone:"",
                    userEmail:"",
                    users:[],
                    errors:[]

                }
            },
            methods:{

                getUsers(){

                    axios.get("{{ url('/institution/public/get-users/') }}"+"/"+this.institutionId).then(res => {

                        this.users = res.data.users

                    })

                },
                getTeachers(){

                    axios.get("{{ url('/institution/public/get-teachers') }}"+"/"+this.institutionId).then(res => {
                        this.registeredEducatorsCount = res.data.teachers
                    })

                },
                unban(){

                    axios.post("{{ url('/reported/institutions/unreport') }}", {"institutionId": this.institutionId}).then(res => {

                        if(res.data.success == true){

                            swal({
                                "text": res.data.msg,
                                "icon": "success"
                            })

                        }else{

                            swal({
                                "text": res.data.msg,
                                "icon": "error"
                            })

                        }

                    })

                }
                
            },
            mounted(){

                this.getUsers()
                this.getTeachers()

                if(this.report > 0){
                    $("#reportIcon").css("fill", "#4674b8")
                }

            }

        })

    </script>

@endpush
    
