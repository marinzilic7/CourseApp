<template>
    <div class="container">
        <form @submit.prevent="regUser" method="POST">
            <input type="hidden" v-model="this.POST" />
            <input type="hidden" name="" v-model="this.csrfToken" />
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input
                    type="text"
                    class="form-control"
                    id="exampleInputEmail1"
                    aria-describedby="emailHelp"
                    placeholder="Name"
                    v-model="form.name"
                />
                <p v-if="errors.name" class="text-danger">
                    {{ errors.name[0] }}
                </p>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Last name</label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Last name"
                    v-model="form.lastName"
                />
                <p v-if="errors.lastName" class="text-danger">
                    {{ errors.lastName[0] }}
                </p>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input
                    type="email"
                    class="form-control"
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
                    placeholder="Password"
                    v-model="form.password"
                /><span class="input-icon" @click="togglePasswordVisibility">
                    <i v-if="showPassword" class="fa fa-eye"></i>
                    <i v-else class="fa fa-eye-slash"></i>
                </span>
                <p v-if="errors.password" class="text-danger">
                    {{ errors.password[0] }}
                </p>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input
                    :type="showPasswordConf ? 'text' : 'password'"
                    class="form-control"
                    placeholder="Password"
                    v-model="form.passwordConfirmation"
                />
                <span class="input-icon" @click="togglePasswordVisibilityConf">
                    <i v-if="showPasswordConf" class="fa fa-eye"></i>
                    <i v-else class="fa fa-eye-slash"></i>
                </span>
                <p v-if="errors.passConf" class="text-danger">
                    {{ errors.passConf[0] }}
                </p>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
            <div class="notiDIV" v-if="successReg">
                <div class="alert alert-success" role="alert">
                    {{ poruka }}
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            form: {
                name: "",
                lastName: "",
                email: "",
                password: "",
                passwordConfirmation: "",
            },
            erorrs: {},
            csrfToken: "",
            poruka: "",
            POST: "",
            successReg: false,
            showPassword: false,
            showPasswordConf:false,
            errors: {},
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
        regUser() {
            const Data = {
                name: this.form.name,
                lastName: this.form.lastName,
                email: this.form.email,
                password: this.form.password,
                passConf: this.form.passwordConfirmation,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/regUser", Data)
                .then((response) => {
                    this.poruka = response.data.poruka;
                    this.successReg = true;
                    this.form = {
                        name: "",
                        lastName: "",
                        email: "",
                        password: "",
                        passwordConfirmation: "",
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
        togglePasswordVisibility() {
            this.showPassword = !this.showPassword;
        },
        togglePasswordVisibilityConf(){
            this.showPasswordConf = !this.showPasswordConf;
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
    margin-top:30px;
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
