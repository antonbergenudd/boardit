<template>
    <div>
        <!-- Button -->
        <div v-show="false" class="flex fixed right-10 bottom-10 cursor-pointer" @click="showChat = !showChat">
            <div class="shadow-md rounded-3xl py-1 px-4 bg-white mr-2 flex justify-center items-center flex">
                <p>Chatta med oss</p>
                <img src="https://twemoji.maxcdn.com/v/13.0.1/72x72/1f44b.png" alt="👋" class="emoji w-5 ml-2">
            </div>
            
            <div class="shadow-md rounded-full bg-project text-white flex justify-center items-center p-4" style="font-size:1.5rem">
                <i class="fa fa-comment"></i>
            </div>
        </div>
        
        <!-- Chat window -->
        <div v-show="showChat" class="fixed w-80 right-10 bottom-5 h-5/6">
            
            <!-- Send button -->
            <button class="absolute bottom-3 -right-5 rounded-3xl bg-project text-white p-4" type="button" :disabled="processingMessage" @click="sendMessage(message)" ><i class="fa fa-paper-plane" style="font-size:1.5rem"></i></button>
            
            <!-- Chat -->
            <div class="h-full w-full rounded-xl flex flex-col overflow-hidden">
                
                <!-- head -->
                <div class="flex-none h-20 flex justify-between items-center bg-project p-6 text-white">
                    <div class="flex justify-center items-center">
                        <img class="rounded-full w-14 mr-2" src="https://schooloflanguages.sa.edu.au/wp-content/uploads/2017/11/placeholder-profile-sq-300x300.jpg" alt="">
                        <div class="flex justify-center items-center">
                            <h1 class="tracking-tight text-3xl font-semibold">Hej där</h1>
                            <img src="https://twemoji.maxcdn.com/v/13.0.1/72x72/1f44b.png" alt="👋" class="emoji w-6 ml-3">
                        </div>
                    </div>
                    
                    <div class="flex justify-center items-center">
                        <button type="button" name="button" @click="showChat = false"><i class="fa fa-arrow-down"></i></button>
                    </div>
                </div>
                
                <div class="flex-none h-12 w-full flex justify-center items-center bg-project-dark-md text-white text-sm">
                    <div class="rounded-full h-2 w-2 bg-green-200 mr-2"></div>
                    <p>Vi svarar vanligtvis inom 15 - 20 minuter</p>
                </div>
                
                <!-- body -->
                <div class="flex-grow w-full px-6 py-4 bg-white">
                    <div v-for="message in messages">
                        <p class="rounded-xl p-4 bg-gray-200 w-max" v-text="message.body"></p>
                        <p class="text-xs text-gray-400 p-1" v-text="message.sent"></p>
                    </div>
                </div>
                
                <!-- footer -->
                <div class="flex-none h-20 w-full bg-white">
                    <hr class="mx-8" />
                    <input class="focus:outline-none w-full p-4" v-model="message" placeholder="Skriv in ditt meddelande..."/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {},
        computed: {
            messages() {
                return [{
                    body: 'Hallå där!',
                    sent: '23:58'
                }];
            }
        },
        data() {
            return {
                message: '',
                showChat: false,
                processingMessage: false
            }
        },
        methods: {
            sendMessage(message) {
                this.processingMessage = true;
                axios.post('/api/message', message).then(response => {
                    this.processingMessage = false;
                    console.log(response);
                }).catch(error => {
                    this.processingMessage = false;
                    alert(error);
                });
            }
        }
    }
</script>
