<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="6" sm="8">
          <b-card no-body class="mx-4">
            <b-card-body class="p-4">
               <form class="ui form" @submit.prevent="validateBeforeSubmit">
                <h1>Register</h1>
                <p class="text-muted">Create your account</p>
                <b-input-group class="mb-3">
                  <b-form-input v-model="firstname"  required="required" type="text" class="form-control" name="firstname" placeholder="Firstname"/>
                </b-input-group>
                <b-input-group class="mb-3">
                  <b-form-input  v-model="lastname" required="required" type="text" class="form-control" name="lastname"  placeholder="Lastname" />
                </b-input-group>
                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text>@</b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input  v-model="email" required="required" type="email" class="form-control" name="email"  placeholder="Email" />
                </b-input-group>

                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text><i class="icon-lock"></i></b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input v-model="password"  required="required" type="password" class="form-control" name="password" placeholder="Password"/>
                </b-input-group>

                <b-input-group class="mb-4">
                  <b-input-group-prepend>
                    <b-input-group-text><i class="icon-lock"></i></b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input v-model="c_password"  required="required" type="password" class="form-control" placeholder="Repeat password" autocomplete="new-password" />
                  
                </b-input-group>
                <b-input-group class="mb-12"><p v-if="error_ms" style="color:red">{{error_ms}}</p></b-input-group>
                <button type="submit" class="btn btn-success btn-block">Create Account</button>
               </form>
            </b-card-body>
          </b-card>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
import VeeValidate from 'vee-validate';
import axios from "axios";
export default {
  name: 'Register',

  data: function() {
      return {
          firstname: '',
          lastname: '',
          email:'',
          password: '',
          c_password:'',
          error_ms:''
        }
    },
    methods: {
      acRegister(){
          axios.post("http://202.28.37.32/mis/parking/api.php?module=register", {
           firstname : this.firstname,
           lastname : this.lastname,
           email : this.email,
           password : this.password
          }).then(response => {
            if(response.data.status == true){
                this.$router.push(this.$route.query.redirect || '/');
            }else{
              this.error_ms = response.data.message;
            }
          }).catch(e => {});
                  
      },
      validateBeforeSubmit() {
         if(this.password !=  this.c_password){
           this.error_ms = 'Please enter the same password as above';
           return false;
         }
         this.acRegister();
      
     
    }
    }
}
</script>
