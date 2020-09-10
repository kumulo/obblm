<template>
  <v-row
      align="center"
      justify="center"
  >
    <v-col
        cols="12"
        sm="8"
        md="4"
    >
      <v-form
          ref="form"
          v-model="valid">
        <v-card class="elevation-12">
          <v-toolbar
              color="primary"
              dark
              flat
          >
            <v-toolbar-title>Login form</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-text-field
                v-model="login"
                label="Login"
                name="login"
                :rules="['Required']"
                prepend-icon="mdi-account"
                type="text"
                required
            ></v-text-field>

            <v-text-field
                v-model="password"
                id="password"
                label="Password"
                name="password"
                :rules="['Required']"
                prepend-icon="mdi-lock"
                type="password"
                required
            ></v-text-field>
            <input type="hidden" name="_csrf_token"
                   value=""
            >
            <input type="hidden" name="_target_path" value=""/>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn class="mr-4" :disabled="!valid" @click="validate" color="success">Login</v-btn>
            <v-btn @click="reset" color="grey">Reset</v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-col>
  </v-row>
</template>

<script>
  import axios from 'axios';
  import store from '../../store';

  export default {
    props: {

    },
    data: () => ({
      store: store,
      valid: false,
      login: '',
      password: '',

      nameRules: [
        v => !!v || 'Name is required',
        v => v.length <= 10 || 'Name must be less than 10 characters',
      ],
      lazy: false,
    }),
    methods: {
      validate() {
        this.valid = this.$refs.form.validate()
        console.log(this.$refs.form)
        console.log(this.$refs.form.login)
      },
      reset() {
        this.$refs.form.reset()
      }
    }
  }
</script>