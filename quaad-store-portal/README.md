# quaad-store-portal

This template should help get you started developing with Vue 3 in Vite.

## Recommended IDE Setup

[VS Code](https://code.visualstudio.com/) + [Vue (Official)](https://marketplace.visualstudio.com/items?itemName=Vue.volar) (and disable Vetur).

## Recommended Browser Setup

- Chromium-based browsers (Chrome, Edge, Brave, etc.):
  - [Vue.js devtools](https://chromewebstore.google.com/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd) 
  - [Turn on Custom Object Formatter in Chrome DevTools](http://bit.ly/object-formatters)
- Firefox:
  - [Vue.js devtools](https://addons.mozilla.org/en-US/firefox/addon/vue-js-devtools/)
  - [Turn on Custom Object Formatter in Firefox DevTools](https://fxdx.dev/firefox-devtools-custom-object-formatters/)

## Customize configuration

See [Vite Configuration Reference](https://vite.dev/config/).

## Project Setup

```sh
npm install
```

### Compile and Hot-Reload for Development

```sh
npm run dev
```

# Compile and Minify for Production

```sh
npm run build
```
## Features to Add

## Create new Order
- Input for the name - Done
- Input for the price - Done
- Textarea for the description - Done
- create store method in OrderController - Done
- create an OrderRequest on the api for the store method to validate the data. - Done
- return a success message upon completion or a failure message - Done
- switch submit to loading upon request being sent - Done

## Filters
- filter to display based on price range
- filter for active items (when active is added)
- filter for similar name (e.g. shoe will retrieve shoes and anything that starts with shoe)

## Edit/View buttons on all rendered orders
- create a show page
- add route to vue router with :id
- create a show method on the api to return the order data.
- use OrderRequest for the show method to validate the data.
- find order and return data to be displayed

## Update functionality
- enable on show page the ability to update the existing order
- validate data using OrderRequest
- find order and update
- return success or failure message 
(optional): Switch submit button text to loading whilst waiting on the api request

## Delete functionality

## Pagination

## Add Active field
- create migration 

## New Relationship 
- order category (footwear, headwear, trousers, etc...) -> one to many relationship