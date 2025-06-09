import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  title: 'LaradminLTE',
  description: 'AdminLTE v4 for Laravel',
  lastUpdated: true,
  base: '/LaradminLTE/',

  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    logo: '/images/framed-logo.png',

    nav: [
      { text: 'Home', link: '/' },
      { text: 'Documentation', link: '/sections/overview/what-is-laradminlte' }
    ],

    sidebar: [
      {
        text: 'Overview',
        collapsed: false,
        items: [
          { text: 'What is LaradminLTE?', link: '/sections/overview/what-is-laradminlte' },
          { text: 'Getting Started', link: '/sections/overview/getting-started' }
        ]
      },
      {
        text: 'Configuration',
        collapsed: false,
        items: [
          { text: 'Layout', link: '/sections/config/layout' },
          { text: 'Menu', link: '/sections/config/menu' },
          { text: 'Plugins', link: '/sections/config/plugins' },
        ]
      },
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/dfsmania/LaradminLTE' }
    ],

    search: {
      provider: 'local'
    }
  },

  // Add extra elements to the head of the HTML document.
  head: [
    ['link', { rel: 'icon', href: '/LaradminLTE/favicon.ico' }]
  ]
})
