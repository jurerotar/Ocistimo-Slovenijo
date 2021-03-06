<template>
    <table class="min-w-table tbl w-full">
        <tr>
            <th class="text-left w-32 md:w-44 dark:text-white">Ime</th>
            <th class="text-left w-20 dark:text-white">Vrsta</th>
            <th class="text-left w-20 dark:text-white">Velikost</th>
            <th class="text-left w-20 dark:text-white">Posodobljeno</th>
            <th class="text-left w-20 dark:text-white">Končnica</th>
            <th class="text-left w-20 dark:text-white">Prenos</th>
        </tr>
        <tr v-for="row in data" :key="row.id">
            <td class="text-left w-32 md:w-44 dark:text-white">{{ row.name }}</td>
            <td class="text-left w-20 dark:text-white">{{ type(row.slug) }}</td>
            <td class="text-left w-20 dark:text-white">{{ niceBytes(row.size) }}</td>
            <td class="text-left w-20 dark:text-white">{{ niceDate(row.last_modified) }}</td>
            <td class="text-left w-20 dark:text-white">{{ row.extension }}</td>
            <td class="text-left dark:text-white">
                <a class="font-semibold rounded-lg px-4 py-2 text-white text-center duration-300
                    transition-colors inline-flex"
                   :class="agreed ? 'bg-green-default hover:bg-green-default-darker' : 'bg-gray-300 cursor-not-allowed'"
                   :href="agreed ? row.url: '#'"
                   :download="row.slug">
                    <icon class="mr-2 h-5 w-5" :type="'download'" :color="'white'"></icon>
                    Prenesi
                </a>
            </td>
        </tr>
    </table>
</template>

<script>
import Icon from "../Icon";

export default {
    name: "ExportTable",
    components: {
        Icon
    },
    computed: {
        agreed() {
            return this.$store.state.termsAndConditionsAgreements.exportTermsAndConditions;
        }
    },
    methods: {
        /**
         * Returns a human readable file size
         * @param {number} bytes
         * @returns {string} size - human readable file size
         */
        niceBytes: (bytes) => {
            if (bytes <= 1) {
                return '1 B';
            }
            const units = ['B', 'kB', 'MB', 'GB'];

            const exponent = Math.min(Math.floor(Math.log(bytes) / Math.log(1000)), units.length - 1);
            const num = (bytes / Math.pow(1000, exponent)).toFixed(2) * 1;
            const unit = units[exponent];

            return `${num} ${unit}`;
        },

        /**
         * Returns a translated type or '/' if none was set
         * @param {string} slug
         * @returns {string} type
         */
        type: (slug) => {
            if (slug === 'skupno') {
                return 'Vsi podatki';
            }
            const isRegion = window.globalData.regions.find(el => el.slug === slug);
            return (isRegion) ? 'Regija' : 'Občina'
        },

        /**
         * Formats date from unix timestamp to Slovenian locale
         * @param {number} date - unix timestamp in seconds
         * @returns {string} date - formatted date
         */
        niceDate: (date) => {
            return (new Date(date * 1000)).toLocaleDateString('sl-SI');
        },
    },
    props: ['data']
}
</script>
