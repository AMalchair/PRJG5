
new Vue({
    el: '#attendance',
    data:{
        students:[],
    },
    methods:{
        updateAttendance(studId,scId){
            console.log("in method")
            console.log(studId)
            axios.post("/updateAttendance",{
                studentId: studId,
                seanceId: scId
            })
            console.log("after")
        },
        addAll(scId){
            console.log('in method addAll')
            axios.post("/updateAllAttendance",{
                seanceId:scId
            })
            console.log("after")
            location.reload()
        }
    }
})
