<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Websocket Notification</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>

                    <form class="px-4 pb-4" method="POST">
                        <div class="form-group">
                            <label>Title</label>
                            <input  v-model="title" type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Body</label>
                            <textarea v-model="message" class="form-control" name="body"></textarea>
                          </div>
                        <button type="submit" class="btn btn-primary" @click="sendNotification">Send Notification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data(){
            return{
                message:'',
                title:'',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            this.listen();
        },
        methods:{
            listen(){
                console.log('listening')
                Echo.channel('notify')
                .listen('.notification' , test => {
                        //For Desktop Browser Notification
                         if (! ('Notification' in window)) {
                        alert('Web Notification is not supported');
                        return;
                        };

                        Notification.requestPermission( permission => {
                            let notification = new Notification('Test', {
                                body: test.message, // content for the alert
                            });

                            // link to page on clicking the notification
                            notification.onclick = () => {
                                window.focus();
                            };
                        });
                        
                    });
            },
            sendNotification(){

                let currentObj = this;
                
                //Form Data
                let formData = new FormData();
                formData.append('title',this.title);
                formData.append('body',this.message);

                //Upload Request
                axios.post('send-notification', formData)
                .then((response) => {
                    currentObj = "";
                     
                    
                })
                .catch((error) => {
                      currentObj.allerros = error.response.data.errors;
                      currentObj.success = false;
                      });
                 
            }
        }
    }
</script>
