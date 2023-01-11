<template>
  <div>
    <div class="horizontal-menu">
      <ul class="menu-elements">
        <li>
          <a href="/">
            <img
                src="../../assets/img/icons/logo-white.svg"
                alt="logo" style="height: 50px; margin-right: 20px">
          </a>
        </li>
        <li>
          <a href="">
            <img class="menu-icon" src="../../assets/img/icons/comments-ligth.svg" alt="likes">
          </a>
        </li>
        <li>
          <a href="">
            <img class="menu-icon" src="../../assets/img/icons/heart-light.svg" alt="likes">
          </a>
        </li>
      </ul>
      <div class="div-menu">
        <a href="">
          <img class="menu-icon" src="../../assets/img/icons/menu-light.svg" alt="likes">
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "NavBar"
}
</script>

<style scoped>
.horizontal-menu {
  background-color: #165BBA;
  box-shadow: 0 0 10px #073779;
  border-radius: 25px;
  margin: 10px;
  min-height: 80px;
  vertical-align: middle;
}

ul {
  margin: 0; /* убрать внутренние отступы */
  padding: 0; /* убрать внешние отступы */

}

.menu-elements {
  float: left;
  line-height: 80px;
  display: flex;
  text-align: center;
  align-items: center;
}

.menu-elements > li {
  line-height: normal;
  display: inline-block;
  vertical-align: middle;
  height: 25px;
  padding: 10px;
}

.menu-icon {
  margin-top: 15px;
  height: 25px;
}

.div-menu {
  margin-top: 10px;
  margin-right: 30px;
  float: right;
}

</style>
