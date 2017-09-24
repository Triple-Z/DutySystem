<template>
    <div id="app"
         class="demo">
        <h1 class="demo-title"></h1>
        <div class="demo-container">
            <schedule-calendar :originData="data"></schedule-calendar>
        </div>
    </div>
</template>
<script>
import scheduleCalendar from './scheduleCalendar'

export default {
    name: 'app',
    components: {
        scheduleCalendar
    },

    data() {
        this.$http.get('holidays/dates').then(response => {
            this.data = response.data.dates;
        }, response => {
            // this.data = [
            //     {
            //         id: 111,
            //         date: '2017-08-02',
            //     },
            //     {
            //         id:222,
            //         date: '2017-08-03'
            //     }
            // ]
        })
        return {
            data: this.data
            
        }
    }
}
</script>
<style lang="less">
html {
    background: #eee
}

body,
html {
    height: 100%;
    overflow: hidden;
}

body {
    margin: 0;
}

.demo {
    display: flex;
    flex-direction: column;
    height: 100%;
    padding: 0 30px 30px;
    box-sizing: border-box;
    margin-left: 16.667%;
}

.demo-title {
    text-align: center
}

.demo-container {
    flex: 1
}
</style>
