
<template>
    <div class="container">
        <form @submit.prevent="logUser" method="POST">
            <input type="hidden" :value="this.POST" />
            <input type="hidden" :value="this.csrfToken" />
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input
                    type="email"
                    class="form-control"
                    id="exampleInputEmail1"
                    aria-describedby="emailHelp"
                    placeholder="Email"
                    v-model="form.email"
                />
                <p v-if="errors.email" class="text-danger">
                    {{ errors.email[0] }}
                </p>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input
                    :type="showPassword ? 'text' : 'password'"
                    class="form-control"
                    id="exampleInputPassword1"
                    placeholder="Password"
                    v-model="form.password"
                />
                <span class="input-icon" @click="togglePasswordVisibility">
                    <i v-if="showPassword" class="fa fa-eye"></i>
                    <i v-else class="fa fa-eye-slash"></i>
                </span>
                <p v-if="errors.password" class="text-danger">
                    {{ errors.password[0] }}
                </p>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <div v-if="successReg" class="notiDIV">
                <div class="alert alert-success" role="alert">
                    {{ poruka }}
                </div>
            </div>
            <div v-if="falseReg" class="notiDIV">
                <div class="alert alert-danger" role="alert">
                    {{ poruka }}
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import router from '../router'
import axios from "axios";
export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
            errors: {},
            csrfToken: "",
            poruka: "",
            falsePoruka:'',
            POST: "",
            successReg: false,
            showPassword: false,
            falseReg:false,

        };
    },
    methods: {
        fetchCsrfToken() {
            axios
                .get("/sanctum/csrf-cookie")
                .then((response) => {
                    this.csrfToken = response.data.csrf_token;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        logUser() {

            const Data = {
                email: this.form.email,
                password: this.form.password,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/logUser", Data)
                .then((response) => {
                    const logiran = true
                    this.$emit('variableChanged', logiran);
                    this.poruka = response.data.poruka;
                    this.successReg = true;
                    if(this.poruka == 'Uspješna prijava'){
                        this.successReg = true
                        this.falseReg = false
                        this.$store.dispatch('login', true);
                        /*  this.$router.push({ path: '/', query: { poruka: this.poruka } }); */
                         this.$router.push('/')
                    }else{
                        this.falseReg = true
                        this.successReg = false
                    }


                    this.form = {
                        email: "",
                        password: "",
                    };
                    this.errors = {};
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {

                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
        togglePasswordVisibility(){
            this.showPassword = !this.showPassword
        }
    },
};
</script>

<style scoped>
.container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 700px;
}
form {
    background-color: #f7f7f7;
    padding: 60px;
}
.form-group input {
    width: 500px;
}
button {
    margin-top: 25px;
    width: 100%;
}
.form-group {
    margin-top: 30px;
}
.notiDIV {
    margin-top: 25px;
}


.input-icon {
    float: right;
    position: relative;
    bottom: 35px;
    right: 20px;
    font-size: 20px;
}
</style>
