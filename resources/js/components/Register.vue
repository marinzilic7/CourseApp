<template>
  <div class="container">
    <form>
      <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input
          type="email"
          class="form-control"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
          placeholder="Name"
        />
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Last name</label>
        <input
          type="email"
          class="form-control"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
          placeholder="Last name"
        />
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input
          type="email"
          class="form-control"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
          placeholder="Email"
        />
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input
          type="password"
          class="form-control"
          id="exampleInputPassword1"
          placeholder="Password"
        />
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>

<script setup></script>

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
  padding:60px;
}
.form-group input {
  width: 500px;
}
button {
  margin-top: 25px;
  width:100%;
}
.form-group {
  margin-top: 30px;
}
</style>
