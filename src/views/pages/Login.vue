<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="8">
          <ul class="list-group">
            <li class="list-group-item list-group-item-success"><h2 class="text-center">Welcome To Sci Parking</h2></li>
          </ul>
          <b-card-group>
            <b-card no-body class="p-4">
              <b-card-body>
                <b-form>
                  <h1>Login</h1>
                  <p class="text-muted">Sign In to your account</p>
                  <b-input-group class="mb-3">
                    <b-input-group-prepend><b-input-group-text><i class="icon-user"></i></b-input-group-text></b-input-group-prepend>
                    <b-form-input type="text" class="form-control" placeholder="email" autocomplete="email" v-model="model_login.email" />
                  </b-input-group>
                  <b-input-group class="mb-4">
                    <b-input-group-prepend><b-input-group-text><i class="icon-lock"></i></b-input-group-text></b-input-group-prepend>
                    <b-form-input type="password" class="form-control" placeholder="Password" autocomplete="current-password" v-model="model_login.password" />
                  </b-input-group>
                  <b-row>
                    <b-col cols="6">
                      <b-button variant="primary" class="px-4" @click="acLogin">Login</b-button>
                    </b-col>
                  </b-row>
                  <b-row>
                    <b-col v-if="error_ms" cols="12">
                      <p class="alert alert-danger" style="margin-top: 15px; margin-bottom: 0;">{{error_ms}}</p>
                    </b-col>
                  </b-row>
                </b-form>
              </b-card-body>
            </b-card>
            <b-card no-body class="text-white bg-primary py-5" style="width:100%">
              <b-card-body class="text-center">
                <div>
                  <h2>Sign up</h2>
                    <div>
                      <img class="navbar-brand-full" src="img/brand/Register.png" width="100" height="100">
                    </div>
                  <b-button variant="primary" class="active mt-3" to="/pages/register">Register Now!</b-button>
                </div>
              </b-card-body>
            </b-card>
          </b-card-group>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import auth from '../../auth'
export default {
  name: 'Login',
   data: function() {
    return {
        model_login: {
        email: '',
        password: ''
      },
      error_ms:''
    }
   },
  methods: {
    acLogin(){
      // this.$router.push({redirect:'/dashboard'});
        axios.post("http://202.28.37.32/mis/parking/api.php?module=login", {
          email: this.model_login.email,
          password: this.model_login.password
        }).then(response => {
          if(response.data.status == true){
            localStorage.user = response.data.data.firstname+' '+response.data.data.lastname
                auth.login(this.model_login.email, this.model_login.password, loggedIn => {
                if (!loggedIn) {
                  this.error = true
                } else {
                  this.$router.push(this.$route.query.redirect || '/dashboard');
                }
              })
            }else{
              this.error_ms = response.data.message;
            }
        }).catch(e => {

        });
    }
  }
}
</script>
