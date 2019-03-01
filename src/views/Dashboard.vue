<template>
  <div class="animated fadeIn">
    <b-card>
      <b-row>
        <b-col sm="3">
          <h4
            id="traffic"
            class="card-title mb-0"
            style="text-transform: capitalize;"
          >{{statusTypeActive}}</h4>
          <!-- <div class="small text-muted">November 2017</div> -->
        </b-col>
        <b-col sm="3" class="d-md-block">
          <div class="row">
            <label class="col-md-6 col-form-label text-right">ประเภทกราฟ :</label>
            <div class="col-md-6">
              <select
                class="form-control"
                v-model="select_input.select_type"
                @change="onChange($event)"
              >
                <option value="daily">ช่วงวันที่</option>
                <option value="duringday">ระหว่างวัน</option>
                <option value="monthly">รายเดือน</option>
                <option value="yearly">รายปี</option>
              </select>
            </div>
          </div>
        </b-col>
        <b-col sm="6" class="d-md-block">
          <!-- ช่วงวันที่ -->
          <div class="row" v-if="statusTypeActive == 'daily'">
            <label class="col-md-2 col-form-label text-right">ป/ด/ว</label>
            <div class="col-md-3">
              <datepicker
                :format="formatDaily"
                v-model="dayly_input.s_date"
                input-class="form-control"
              ></datepicker>
            </div>
            <label class="col-md-2 col-form-label text-right">ถึง ป/ด/ว</label>
            <div class="col-md-3">
              <datepicker
                :format="formatDaily"
                v-model="dayly_input.e_date"
                input-class="form-control"
              ></datepicker>
            </div>
            <div class="col-md-2">
              <button type="button" @click="searchDate" class="btn btn-primary" >ค้นหา</button>
            </div>
          </div>
          <!-- ------------------------------------------------------ -->
          <div class="row" v-if="statusTypeActive == 'duringday'">
            <label class="col-md-2 col-form-label text-right">ป/ด/ว</label>
            <div class="col-md-3">
              <datetime type="datetime" v-model="duringday_input.s_duringday" input-class="form-control" format="yyyy-MM-dd HH:mm:ss"></datetime>
            </div>
            <label class="col-md-2 col-form-label text-right">ถึง ป/ด/ว</label>
            <div class="col-md-3">
              <datetime type="datetime" v-model="duringday_input.e_duringday" input-class="form-control" format="yyyy-MM-dd HH:mm:ss"></datetime>
            </div>
            <div class="col-md-2">
              <button type="button" @click="searchDate" class="btn btn-primary" >ค้นหา</button>
            </div>
          </div>
          <!-- ------------------------------------------------------ -->
          <!-- รายเดือน -->
          <div class="row" v-if="statusTypeActive == 'monthly'">
            <label class="col-md-2 col-form-label text-right">เดือน</label>
            <div class="col-md-3">
              <datepicker
                :format="formatMonthly"
                :minimumView="'month'"
                :maximumView="'month'"
                v-model="monthly_input.s_month"
                input-class="form-control"
              ></datepicker>
            </div>
            <label class="col-md-2 col-form-label text-right">ถึงเดือน</label>
            <div class="col-md-3">
              <datepicker
                :format="formatMonthly"
                :minimumView="'month'"
                :maximumView="'month'"
                v-model="monthly_input.e_month"
                input-class="form-control"
              ></datepicker>
            </div>
            <div class="col-md-2">
              <button type="button" @click="searchDate" class="btn btn-primary" >ค้นหา</button>
            </div>
          </div>
          <!-- รายปี -->
          <div class="row" v-if="statusTypeActive == 'yearly'">
            <label class="col-md-2 col-form-label text-right">ปี</label>
            <div class="col-md-3">
              <datepicker
                :format="formatYearly"
                :minimumView="'year'"
                :maximum-view="'year'"
                v-model="yearly_input.s_year"
                input-class="form-control"
              ></datepicker>
            </div>
            <label class="col-md-2 col-form-label text-right">ถึงปี</label>
            <div class="col-md-3">
              <datepicker
                :format="formatYearly"
                :minimumView="'year'"
                :maximum-view="'year'"
                v-model="yearly_input.e_year"
                input-class="form-control"
              ></datepicker>
            </div>
            <div class="col-md-2">
              <button type="button" @click="searchDate" class="btn btn-primary">ค้นหา</button>
            </div>
          </div>
        </b-col>
      </b-row>
      <daily v-if="typeChart == 'Line'"
        class="chart-wrapper"
        :data="chartData"
        style="height:400px;margin-top:40px;"
        height="100"
      ></daily>
       <bchart v-if="typeChart == 'Bar'"
        class="chart-wrapper"
        :data="chartData"
        style="height:400px;margin-top:40px;"
        height="100"
      ></bchart>
      <b-row>
        <b-col sm="12" class="text-center" style="margin-top:25px;">
          Max IN : <span style="color:#009688;">{{formatNumber(maxIn)}}</span> 
          Max Out : <span style="color:#f87979;">{{formatNumber(maxOut)}}</span>
        </b-col>
        <b-col sm="12" class="text-center" style="margin-top:15px;">
          <button class="btn btn-primary" type="button" @click="actionLine" style="margin:2px 5px;"> line</button>  
          <button class="btn btn-primary" type="button" @click="actionBar" style="margin:2px 5px;"> bar</button>  
        </b-col>
      </b-row>
    </b-card>
  </div>
</template>

<script>
import Daily from "./dashboard/Daily";
import Bchart from "./dashboard/Bchart";
import Datepicker from "vuejs-datepicker";
import { Datetime } from 'vue-datetime';
import { Callout } from "@coreui/vue";
import moment from "moment";
import axios from "axios";

export default {
  name: "dashboard",
  components: {
    Callout,
    Datepicker,
    Daily,
    Bchart,
    datetime: Datetime
  },
  async created() {
    this.loadDataDaily();
  },
  data: function() {
    return {
      maxIn:0,
      maxOut:0,
      typeChart:'Line',
      select_input: {
        select_type: "daily"
      },
      dayly_input: {
        s_date: "2017-02-04",
        e_date: "2017-02-20"
      },
      duringday_input: {
        s_duringday: "2017-02-04",
        e_duringday: "2017-02-04"
      },
      monthly_input: {
        s_month: "2017-02",
        e_month: "2017-06"
      },
      yearly_input: {
        s_year: "2017",
        e_year: "2017"
      },
      chartTitle: "Daily",
      chartData: null,
      statusTypeActive: "daily",
      formatDaily: "yyyy-MM-dd",
      formatDuringday: "yyyy-MM-dd",
      formatMonthly: "yyyy-MM",
      formatYearly: "yyyy",
      formatDateTime: "yyyy-MM-dd HH:mm:ss"
    };
  },

  methods: {
    async loadDataDaily() {
     axios
          .post("http://202.28.37.32/mis/parking/api.php?module=day-total", {
            s_date: this.dayly_input.s_date,
            e_date: this.dayly_input.e_date
          })
          .then(response => {
            let dataInArr = response.data.dataIn;
            let dataOutArr = response.data.dataOut;
            let dataInV = [];
            let dataInL = [];
            let dataOutV = [];
            let dataOutL = [];
            for (let i = 0; i < dataInArr.length; i++) {
              dataInV.push(dataInArr[i].total);
              dataInL.push(dataInArr[i].time);
            }
            for (let i = 0; i < dataOutArr.length; i++) {
              dataOutV.push(dataOutArr[i].total);
              dataOutL.push(dataOutArr[i].time);
            }
            this.maxIn = Math.max.apply(null, dataInV);
            this.maxOut = Math.max.apply(null, dataOutV);
            this.chartData = {
              labels: dataInL,
              datasets: [
                {
                  label: "IN",
                  backgroundColor: "#097509",
                  data: dataInV
                },
                {
                  label:'OUT',
                  backgroundColor: "#1C90F3",
                  data: dataOutV
                },
              ]
            };
          })
          .catch(e => {});
    },
    actionLine(){
      this.typeChart='Line'
       this.searchDate();
    },
    actionBar(){
      this.typeChart='Bar'
      this.searchDate();
    },
    formatNumber(value) {
        return value.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    },
    searchDate() {
      if (this.select_input.select_type == "daily") {
        axios
          .post("http://202.28.37.32/mis/parking/api.php?module=day-total", {
            s_date: this.dayly_input.s_date,
            e_date: this.dayly_input.e_date
          })
          .then(response => {
            let dataInArr = response.data.dataIn;
            let dataOutArr = response.data.dataOut;
            let dataInV = [];
            let dataInL = [];
            let dataOutV = [];
            let dataOutL = [];
            for (let i = 0; i < dataInArr.length; i++) {
              dataInV.push(dataInArr[i].total);
              dataInL.push(dataInArr[i].time);
            }

            for (let i = 0; i < dataOutArr.length; i++) {
              dataOutV.push(dataOutArr[i].total);
              dataOutL.push(dataOutArr[i].time);
            }

           this.maxIn = Math.max.apply(null, dataInV);
            this.maxOut = Math.max.apply(null, dataOutV);
            this.chartData = {
              labels: dataInL,
              datasets: [
                {
                  label: "IN",
                  backgroundColor: "#097509",
                  data: dataInV
                },
                {
                  label:'OUT',
                  backgroundColor: "#1C90F3",
                  data: dataOutV
                },
              ]
            };
          })
          .catch(e => {});
      } else if (this.select_input.select_type == "duringday") {
        this.chartTitle = "Duringday";

        axios
          .post("http://202.28.37.32/mis/parking/api.php?module=duringday", {
            s_duringday: moment(this.duringday_input.s_duringday).format("YYYY-MM-DD HH:mm:ss"),
            e_duringday: moment(this.duringday_input.e_duringday).format("YYYY-MM-DD HH:mm:ss")
          })
          .then(response => {
            let dataInArr = response.data.dataIn;
            let dataOutArr = response.data.dataOut;
            let dataInV = [];
            let dataInL = [];
            let dataOutV = [];
            let dataOutL = [];
            for (let i = 0; i < dataInArr.length; i++) {
              dataInV.push(dataInArr[i].total);
              dataInL.push(dataInArr[i].time);
            }
            for (let i = 0; i < dataOutArr.length; i++) {
              dataOutV.push(dataOutArr[i].total);
              dataOutL.push(dataOutArr[i].time);
            }
            this.maxIn = Math.max.apply(null, dataInV);
            this.maxOut = Math.max.apply(null, dataOutV);
            this.chartData = {
              labels: dataInL,
              datasets: [
                {
                  label: "IN",
                  backgroundColor: "#097509",
                  data: dataInV
                },
                {
                  label:'OUT',
                  backgroundColor: "#1C90F3",
                  data: dataOutV
                },
              ]
            };
          })
          .catch(e => {});
      }
      else if (this.select_input.select_type == "monthly") {
        this.chartTitle = "Monthly";

        axios
          .post("http://202.28.37.32/mis/parking/api.php?module=month-total", {
            s_month: this.monthly_input.s_month,
            e_month: this.monthly_input.e_month
          })
          .then(response => {
            let dataInArr = response.data.dataIn;
            let dataOutArr = response.data.dataOut;
            let dataInV = [];
            let dataInL = [];
            let dataOutV = [];
            let dataOutL = [];
            for (let i = 0; i < dataInArr.length; i++) {
              dataInV.push(dataInArr[i].total);
              dataInL.push(dataInArr[i].time);
            }
            for (let i = 0; i < dataOutArr.length; i++) {
              dataOutV.push(dataOutArr[i].total);
              dataOutL.push(dataOutArr[i].time);
            }
            this.maxIn = Math.max.apply(null, dataInV);
            this.maxOut = Math.max.apply(null, dataOutV);
            this.chartData = {
              labels: dataInL,
              datasets: [
                {
                  label: "IN",
                  backgroundColor: "#097509",
                  data: dataInV
                },
                {
                  label:'OUT',
                  backgroundColor: "#1C90F3",
                  data: dataOutV
                },
              ]
            };
          })
          .catch(e => {});
      } else if (this.select_input.select_type == "yearly") {
        this.chartTitle = "Yearly";
        axios
          .post("http://202.28.37.32/mis/parking/api.php?module=year-total", {
            s_year: this.yearly_input.s_year,
            e_year: this.yearly_input.e_year
          })
          .then(response => {
            let dataInArr = response.data.dataIn;
            let dataOutArr = response.data.dataOut;
            let dataInV = [];
            let dataInL = [];
            let dataOutV = [];
            let dataOutL = [];
            for (let i = 0; i < dataInArr.length; i++) {
              dataInV.push(dataInArr[i].total);
              dataInL.push(dataInArr[i].time);
            }
            for (let i = 0; i < dataOutArr.length; i++) {
              dataOutV.push(dataOutArr[i].total);
              dataOutL.push(dataOutArr[i].time);
            }
            this.maxIn = Math.max.apply(null, dataInV);
            this.maxOut = Math.max.apply(null, dataOutV);
            this.chartData = {
              labels: dataInL,
              datasets: [
                {
                  label: "IN",
                  backgroundColor: "#097509",
                  data: dataInV
                },
                {
                  label:'OUT',
                  backgroundColor: "#1C90F3",
                  data: dataOutV
                },
              ]
            };
          })
          .catch(e => {});
      }
    },
    onChange(event) {
      this.statusTypeActive = event.target.value;
    }
  }
};
</script>

<style>
/* IE fix */
#card-chart-01,
#card-chart-02 {
  width: 100% !important;
}
</style>
