<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>JheckDoc</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {!!JheckDoc::installStyles()!!}
    </head>
    <body>
        <div id="app">
            <nav class="navbar" role="navigation" aria-label="main navigation">
                <div class="navbar-brand">
                    JheckDoc
                </div>
            </nav>

            <div id="main-wrapper">
                <div class="left-col">
                    <aside id="main-menu" class="menu">
                        <template
                            v-for="(route, group) in jheckdoc.menu"
                            :key="group"
                        >

                            <p
                                v-if="group !== 'none'"
                                class="menu-label"
                            >@{{group}}</p>

                            <ul
                                class="menu-list"
                                :class="{'no-group' : group === 'none'}"
                            >
                                <li
                                    v-for="(subRoute, subGroup) in route"
                                    :key="`${group}_${subGroup}`"
                                >
                                    <a
                                        :href="`${jheckdoc.url}?group=${group}&route=${subRoute}`"
                                        :class="{'is-active' : subRoute === activeRoute}"
                                    >@{{subRoute}}</a>
                                </li>
                            </ul>

                        </template>

                    </aside>

                </div>
                <div class="right-col">
                    <main id="main-content">
                        <template v-if="error">
                            <div class="notification is-danger">
                                @{{error}}
                            </div>
                        </template>
                        <template v-else>
                            <h1 class="title is-1">@{{info.name}}</h1>

                            <div class="notification endpoint">
                                <span class="tag method is-success">@{{info.method}}</span> – <span>@{{info.route}}</span>
                            </div>

                            <p v-if="info.description">@{{info.description}}</p>
                            <hr>

                            <div class="tabs">
                                <ul>
                                    <li v-if="hasParams" :class="{'is-active' : activeTab === 'parameters'}"><a @click="changeTab('parameters')">Parameters</a></li>
                                    <li v-if="hasHeaders" :class="{'is-active' : activeTab === 'headers'}"><a @click="changeTab('headers')">Headers</a></li>
                                    <li v-if="hasResponses" :class="{'is-active' : activeTab === 'responses'}"><a @click="changeTab('responses')">Responses</a></li>
                                    <li :class="{'is-active' : activeTab === 'sandbox'}"><a @click="changeTab('sandbox')">Sandbox</a></li>
                                </ul>
                            </div>

                            <div id="parameters-tab" v-if="activeTab === 'parameters'">
                                <h3 class="title is-3">Parameters</h3>
                                <table class="table is-bordered is-hoverable is-fullwidth mb-6">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(params, key) in info.params"
                                            :key="`params-{key}`"
                                        >
                                            <td>@{{key}}</td>
                                            <td>@{{params.type}}</td>
                                            <td>@{{ params.required ? 'Required' : 'Optional'}}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div
                                    v-for="(params, key) in info.params"
                                    :key="`params-{key}`"
                                >
                                    <h4 class="title is-4">@{{key}}</h4>
                                    <ul>
                                        <li>Type: <code>@{{ params.type }}</code></li>
                                        <li>Required: <code>@{{params.required ? 'true' : 'false'}}</code>  </li>
                                        <li v-if="params.description">Description: @{{params.description}}</li>
                                    </ul>

                                    <hr>

                                </div>

                            </div>

                            <div id="headers-tab" v-if="activeTab === 'headers'">
                                <h3 class="title is-3">Headers</h3>
                                <table class="table is-bordered is-hoverable is-fullwidth mb-6">
                                    <thead>
                                        <tr>
                                            <th>Content</th>
                                            <th>Value</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(params, key) in info.headers"
                                            :key="`params-{key}`"
                                        >
                                            <td>@{{key}}</td>
                                            <td>@{{params.value}}</td>
                                            <td>@{{ params.required ? 'Required' : 'Optional'}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div id="responses-tab" v-if="activeTab === 'responses'">

                                <h3 class="title is-3">Responses</h3>

                                <table class="table is-bordered is-hoverable is-fullwidth mb-6">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(params, code) in info.responses"
                                            :key="`params-{code}`"
                                        >
                                            <td>@{{code}}</td>
                                            <td>@{{params.description}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div id="sandbox-tab" v-if="activeTab === 'sandbox'">
                                sandbox
                            </div>

                        </template>
                    </main>
                </div>
            </div>
        </div>
        {!!JheckDoc::installScripts()!!}
    </body>
</html>
