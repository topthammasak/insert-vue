export default {
  items: [
    {
      name: 'Dashboard',
      url: '/dashboard',
      icon: 'icon-speedometer',
      badge: {
        variant: 'primary',
        text: 'NEW'
      }
    },
    {
      title: true,
      name: 'Theme',
      class: '',
      wrapper: {
        element: '',
        attributes: {}
      }
    },
    {
      name: 'Colors',
      url: '/theme/colors',
      icon: 'icon-drop'
    },
    {
      name: 'Typography',
      url: '/theme/typography',
      icon: 'icon-pencil'
    },
    {
      title: true,
      name: 'Components',
      class: '',
      wrapper: {
        element: '',
        attributes: {}
      }
    },
    {
      name: 'Widgets',
      url: '/widgets',
      icon: 'icon-calculator',
      badge: {
        variant: 'primary',
        text: 'NEW'
      }
    },
    {
      divider: true
    },
    {
      title: true,
      name: 'Extras'
    },
    {
      name: 'Pages',
      url: '/pages',
      icon: 'icon-star',
      children: [
        {
          name: 'Login',
          url: '/pages/login',
          icon: 'icon-star'
        },
        {
          name: 'Register',
          url: '/pages/register',
          icon: 'icon-star'
        },
        {
          name: 'Error 404',
          url: '/pages/404',
          icon: 'icon-star'
        },
        {
          name: 'Error 500',
          url: '/pages/500',
          icon: 'icon-star'
        }
      ]
    },
    {
      name: 'Disabled',
      url: '/dashboard',
      icon: 'icon-ban',
      badge: {
        variant: 'secondary',
        text: 'NEW'
      },
      attributes: { disabled: true },
    },
    {
      name: 'Download CoreUI',
      url: 'http://coreui.io/vue/',
      icon: 'icon-cloud-download',
      class: 'mt-auto',
      variant: 'success',
      attributes: { target: '_blank', rel: 'noopener' }
    },
    {
      name: 'Try CoreUI PRO',
      url: 'http://coreui.io/pro/vue/',
      icon: 'icon-layers',
      variant: 'danger',
      attributes: { target: '_blank', rel: 'noopener' }
    },
  ]
}
