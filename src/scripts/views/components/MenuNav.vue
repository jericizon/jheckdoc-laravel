<template>
<div>
  <router-link
    class="flex justify-center items-center text-lg font-bold text-gray-800 dark:text-gray-200"
    :to="{url: '/'}"
  >
    <img
      alt="JheckDoc"
      width="50"
      height="50"
      :src="jheckDocLogo"
    >
    <span class="ml-2">Jheck Doc</span>
  </router-link>
  <ul class="mt-6">
    <li
      v-for="(routes, group) in getMenuLinks"
      :key="`group-menu-${group}`"
      class="relative px-6 py-3"
    >
      <div
        class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
      >
        <span class="inline-flex items-center uppercase">
          {{group}}
        </span>
      </div>

      <ul
        x-transition:enter="transition-all ease-in-out duration-300"
        x-transition:enter-start="opacity-25 max-h-0"
        x-transition:enter-end="opacity-100 max-h-xl"
        x-transition:leave="transition-all ease-in-out duration-300"
        x-transition:leave-start="opacity-100 max-h-xl"
        x-transition:leave-end="opacity-0 max-h-0"
        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-100 dark:text-gray-400 dark:bg-gray-900"
        aria-label="submenu"
      >
        <li
          class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          v-for="(route, key) in routes"
          :key="`menu-${key}`"
        >
          <span
            v-if="activeMenu === `${route.url}__${route.method}`"
            class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
            aria-hidden="true"
          ></span>
          <router-link
            class="w-full block"
            :to="{ name: 'app', query: { url: route.url, method: route.method }}"
            :class="{'text-gray-700' : activeMenu === `${route.url}__${route.method}` }"
          >
            {{ route.name }}
          </router-link>
        </li>
      </ul>
    </li>
  </ul>
</div>
</template>

<script>
export default {
  name: 'MenuNav',
  props: {
    string: { type: String, default: '' },
    number: { type: Number, default: 0 },
    array: { type: Array, default: () => [] },
    object: { type: Object, default: () => ({}) },
    boolean: { type: Boolean, default: false },
  },
  method() {
    this.jheckDocLogo = base64Logo();
  },
};
</script>
