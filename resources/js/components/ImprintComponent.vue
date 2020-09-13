
<template>
    <v-row class="imprint-bg">
        <v-col cols="12" sm="6">
            <a href="/" class="d-block text-center imprint-logo">
                <img :src="logoImage" class="logo logo--large" alt="offlist" />
            </a>
        </v-col>
        <v-col cols="12" sm="6" class="imprint-content">
            <p class="title mt-6 mb-8 font-normal">
                IMPRESSUM
            </p>
            <p>
                Dietz Management & Consulting GmbH<br/>
                Im Mediapark 5d<br/>
                50670 Köln<br/>
                <br/>
                Fon: <a href="tel:+4922197583346">+49 (0)221 975833 46</a><br/>
                Fax: <a href="tel:+4922197583389">+49 (0)221 975833 89</a><br/>
                E-Mail: <a href="mailto:info@offlist.de">info@offlist.de</a><br/>
                <br/>
                Dietz Management & Consulting GmbH wird vertreten durch:<br/>
                Marcel Dietz<br/>
                <br/>
                Umsatzsteuer-Identifikationsnummer gemäß § 27a Umsatzsteuergesetz: folgt<br/>
                Registergericht: Amtsgericht Köln<br/>
                Handelsregister<br/>
                Registernummer: HRB 75104<br/>
                <br/>
                Haftungshinweis:<br/>
                Trotz sorgfältiger inhaltlicher Kontrolle übernehmen wir keine Haftung für die Inhalte externer Links.<br/>
                Für den Inhalt der verlinkten Seiten sind ausschließlich deren Betreiber verantwortlich.<br/>
            </p>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        data() {
            return {
                logoImage: '/images/logo.svg',
            };
        }
    }
</script>
