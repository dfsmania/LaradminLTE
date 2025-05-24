import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  title: "LaradminLTE",
  description: "AdminLTE v4 for Laravel",
  lastUpdated: true,
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    nav: [
      { text: 'Home', link: '/' },
      { text: 'Documentation', link: '/sections/overview/what-is-laradminlte' }
    ],

    sidebar: [
      {
        text: 'Overview',
        collapsed: false,
        items: [
          { text: "What is LaradminLTE?", link: '/sections/overview/what-is-laradminlte' },
          { text: 'Getting Started', link: '/sections/overview/getting-started' }
        ]
      },
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/dfsmania/LaradminLTE' }
    ]
  }
})
