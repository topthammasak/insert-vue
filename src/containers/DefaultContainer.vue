<template>
  <div class="app">
    <AppHeader fixed style="background: slategray; color: white;">
      <SidebarToggler class="d-lg-none" display="md" mobile />
      <b-link class="navbar-brand" to="#">
        <img class="navbar-brand-minimized" src="img/brand/sygnet.svg" width="20" height="20" alt="CoreUI Logo">
      </b-link>
      <b-navbar-nav class="ml-auto">
        {{(fname_lname)? fname_lname : ''}}
        <DefaultHeaderDropdownAccnt/>
      </b-navbar-nav>
    
    </AppHeader>
    <div class="app-body">
      
      <main class="main">
        <!-- <Breadcrumb :list="list"/> -->
        <div class="container-fluid">
          <router-view></router-view>
        </div>
      </main>
      <AppAside fixed>
        <!--aside-->
        <DefaultAside/>
      </AppAside>
    </div>
    
  </div>
</template>

<script>
import nav from '@/_nav'
import { Header as AppHeader, SidebarToggler, Sidebar as AppSidebar, SidebarFooter, SidebarForm, SidebarHeader, SidebarMinimizer, SidebarNav, Aside as AppAside, AsideToggler, Footer as TheFooter, Breadcrumb } from '@coreui/vue'
import DefaultAside from './DefaultAside'
import DefaultHeaderDropdownAccnt from './DefaultHeaderDropdownAccnt'

export default {
  name: 'DefaultContainer',
  components: {
    AsideToggler,
    AppHeader,
    AppSidebar,
    AppAside,
    TheFooter,
    Breadcrumb,
    DefaultAside,
    DefaultHeaderDropdownAccnt,
    SidebarForm,
    SidebarFooter,
    SidebarToggler,
    SidebarHeader,
    SidebarNav,
    SidebarMinimizer
  },
  data () {
    return {
      nav: nav.items,
      fname_lname:localStorage.user
    }
  },
  computed: {
    name () {
      return this.$route.name
    },
    list () {
      return this.$route.matched.filter((route) => route.name || route.meta.label )
    }
  }
}
</script>
