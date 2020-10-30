<template>
  <div class="d-flex align-items-center min-vh-100">
    <CContainer fluid>
      <CRow class="justify-content-center">
        <CCol md="6">
          <CCard class="mx-4 mb-0">
            <CCardBody class="p-4">
              <CForm @submit.prevent="register" method="POST">
                <h1>Cadastro</h1>
                <p class="text-muted">Crie sua conta</p>
                <CInput
                  placeholder="Nome "
                  prependHtml="<i class='cui-user'></i>"
                  autocomplete="username"
                  v-model="name"
                >
                  <template #prepend-content
                    ><CIcon name="cil-user"
                  /></template>
                </CInput>
                <CInput
                  placeholder="Email"
                  prepend="@"
                  autocomplete="email"
                  v-model="email"
                />
                <CInput
                  placeholder="Senha"
                  type="password"
                  prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="new-password"
                  v-model="password"
                >
                  <template #prepend-content
                    ><CIcon name="cil-lock-locked"
                  /></template>
                </CInput>
                <CInput
                  placeholder="Repita a senha"
                  type="password"
                  prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="new-password"
                  class="mb-4"
                  v-model="password_confirmation"
                >
                  <template #prepend-content
                    ><CIcon name="cil-lock-locked"
                  /></template>
                </CInput>
                <CButton type="submit" color="success" block
                  >Criar sua conta</CButton>
                  <br>
                <p v-if="errors.length">
                  <b>Por favor, corrija o(s) seguinte(s) erro(s):</b>
                  <ul>
                    <li class="text-danger font-weight-bold" v-for="error in errors" :key="error">{{ error }}</li>
                  </ul>
                </p>
              </CForm>
            </CCardBody>
            <CCardFooter class="p-4">
              <CRow>
                <CCol col="6">
                  <CButton block color="facebook"> Facebook </CButton>
                </CCol>
                <CCol col="6">
                  <CButton block color="twitter"> Twitter </CButton>
                </CCol>
              </CRow>
            </CCardFooter>
          </CCard>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

  <script>
import axios from "axios";
export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      errors: [],
    };
  },
  methods: {
    register() {
      var self = this;
      axios
        .post(this.$apiAdress + "/api/register", {
          name: self.name,
          email: self.email,
          password: self.password,
          password_confirmation: self.password_confirmation,
        })
        .then(function (response) {
          self.name = "";
          self.email = "";
          self.password = "";
          self.password_confirmation = "";
          console.log(response);
          console.log(response.data.access_token);
          console.log(response.data.roles);

          localStorage.setItem("api_token", response.data.access_token);
          localStorage.setItem("roles", response.data.roles);
          self.$router.push({ path: "dashboard" });
        })
        .catch(function (error) {
          console.log(error.response.data.errors.name);
          console.log(self.password.length);
          self.errors = [];

          if (typeof(error.response.data.errors.name) != 'undefined' ) {
            self.errors.push(error.response.data.errors.name[0]);
          }
          if (typeof(error.response.data.errors.password) != 'undefined') {
            error.response.data.errors.password.forEach(function (value, key) {
              self.errors.push(value);
            });
          }
          if (typeof(error.response.data.errors.email) != 'undefined') {
            self.errors.push(error.response.data.errors.email[0]);
          }
        });
    },
  },
};
</script>
