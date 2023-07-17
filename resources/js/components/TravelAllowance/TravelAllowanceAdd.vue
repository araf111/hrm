<template>
  <div class="row">

    <!--top tabs-->
    <div class="col-12">
      <ul class="nav nav-pills mb-4">
        <li
          v-for="tab in tabs"
          :key="tab.name"
          class="nav-item"
          @click="toggleTab(tab)"
        >
          <a
            :class="['nav-link', {active: tab.active}]"
            href="#"
          >
            {{tab.name}}
          </a>
        </li>
      </ul>
    </div>

    <!--tab contents-->
    <div
      v-if="!viewMode"
      class="col-12"
    >
      <div class="card">
        <div class="card-header card-title-with-btn">
          <div class="card-title-text">ভ্রমণ ভাতা বিলের তালিকা</div>
          <div class="card-title-btns"></div>
        </div>
        <div class="card-body">

          <form class="form-inline add-form">
            <div class="form-group mb-2">
              <label>হিসাবের খাত</label>
              <select
                class="form-control"
                v-model="form.travelBill.billType"
              >
                <option disabled value=""></option>
                <option
                  v-for="travelBillType in travelBillTypes"
                  :key="travelBillType.id"
                  :value="travelBillType.id"
                >
                  {{travelBillType.name_bn}}
                </option>
              </select>
            </div>
            <div class="form-group mx-sm-3 mb-2">
              <label>গমনের স্থান<span class="text-danger">*</span></label>
              <input
                type="text"
                class="form-control"
                v-model="form.travelBill.fromPlace"
              />
            </div>
            <div class="form-group mx-sm-3 mb-2">
              <label>তারিখ<span class="text-danger">*</span></label>
              <datepicker
                v-model="form.travelBill.fromDate"
                name="travel_from_date"
                input-class="form-control"
              ></datepicker>
            </div>
            <div class="form-group mb-2">
              <label>সময়<span class="text-danger">*</span></label>
              <select
                class="form-control"
                v-model="form.travelBill.fromTime"
              >
                <option></option>
                <option
                  v-for="time in times"
                  :key="time"
                  :value="time"
                >
                  {{time}}
                </option>
              </select>
            </div>
            <div class="form-group mx-sm-3 mb-2">
              <label>আগমনের স্থান<span class="text-danger">*</span></label>
              <input
                type="text"
                class="form-control"
                v-model="form.travelBill.toPlace"
              />
            </div>
            <div class="form-group mx-sm-3 mb-2">
              <label>তারিখ<span class="text-danger">*</span></label>
              <datepicker
                v-model="form.travelBill.toDate"
                name="travel_to_date"
                input-class="form-control"
              ></datepicker>
            </div>
            <div class="form-group mb-2">
              <label>সময়<span class="text-danger">*</span></label>
              <select
                class="form-control"
                v-model="form.travelBill.toTime"
              >
                <option></option>
                <option
                  v-for="time in times"
                  :key="time"
                  :value="time"
                >
                  {{time}}
                </option>
              </select>
            </div>
          </form>

          <!--travel expense form-->
          <form
            v-if="form.travelBill.billType === 2"
            class="form-inline add-form travel-expense-form mt-4"
          >
            <div class="form-group mb-2">
              <label>ভ্রমণের প্রকৃতি<span class="text-danger">*</span></label>
              <select
                class="form-control"
                v-model="form.travelBill.travelType"
              >
                <option></option>
                <option
                  v-for="travelType in travelTypes"
                  :key="travelType"
                  :value="travelType"
                >
                  {{travelType}}
                </option>
              </select>
            </div>
            <div class="form-group mx-sm-3 mb-2">
              <label>ভ্রমণের শ্রেণী</label>
              <input
                type="text"
                class="form-control"
                v-model="form.travelBill.travelExpense.class"
              />
            </div>
            <div class="form-group mx-sm-3 mb-2">
              <label>ভাড়ার সংখ্যা<span class="text-danger">*</span></label>
              <input
                type="number"
                class="form-control"
                v-model="form.travelBill.travelExpense.costCount"
              />
            </div>
            <div class="form-group mx-sm-3 mb-2">
              <label>ভাড়ার পরিমান<span class="text-danger">*</span></label>
              <input
                type="number"
                class="form-control"
                v-model="form.travelBill.travelExpense.costAmount"
              />
            </div>
            <div class="form-group mx-sm-3 mb-2">
              <label>মোট ভাড়া</label>
              <input
                type="number"
                class="form-control"
                :value="(form.travelBill.travelExpense.costAmount * form.travelBill.travelExpense.costCount)"
                disabled
              />
            </div>
            <div class="form-group">
              <label>&nbsp;</label>
              <button
                type="submit"
                class="btn btn-success mb-2 ml-3"
                @click="addData"
              >
                তালিকায় যোগ
              </button>
            </div>
          </form>

          <!--travel allowance form-->
          <form
            v-if="form.travelBill.billType === 1"
            class="form-inline add-form travel-allowance-form mt-4"
          >
            <div class="form-group mb-2">
              <label>ভ্রমণের প্রকৃতি<span class="text-danger">*</span></label>
              <select
                class="form-control"
                v-model="form.travelBill.travelType"
              >
                <option></option>
                <option
                  v-for="travelType in travelTypes"
                  :key="travelType"
                  :value="travelType"
                >
                  {{travelType}}
                </option>
              </select>
            </div>
            <div class="form-group mx-sm-3 mb-2">
              <label>ভাতার পরিমান<span class="text-danger">*</span></label>
              <input
                type="number"
                class="form-control"
                v-model="form.travelBill.travelAllowance.costAmount"
              />
            </div>
            <div class="form-group mx-sm-3 mb-2">
              <label>দূরত্ব (কি. মি.)<span class="text-danger">*</span></label>
              <input
                type="number"
                class="form-control"
                v-model="form.travelBill.travelAllowance.distance"
              />
            </div>
            <div class="form-group mx-sm-3 mb-2">
              <label>মোট ভাতা</label>
              <input
                type="number"
                class="form-control"
                :value="(form.travelBill.travelAllowance.distance * form.travelBill.travelAllowance.costAmount) > 0 ? (form.travelBill.travelAllowance.distance * form.travelBill.travelAllowance.costAmount) : form.travelBill.travelAllowance.costAmount"
                disabled
              />
            </div>
            <div class="form-group">
              <label>&nbsp;</label>
              <button
                type="submit"
                class="btn btn-success mb-2 ml-3"
                @click="addData"
              >
                তালিকায় যোগ
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>

    <div class="col-12">
      <travel-allowance-add-list
        :bill-types="billTypes"
        :is-bill-submitted="isSubmitted"
        :data-list="dataList"
        :main-page-url="mainPageUrl"
        :user="user"
        :view-mode="viewMode"
        @remove-item="removeItemFromData"
        @action-fired="handleAction"
      ></travel-allowance-add-list>
    </div>

  </div>
</template>

<script>
import './TravelAllowanceAdd.scss';
import TravelAllowanceAddList from './TravelAllowanceAddList';
import Datepicker from 'vuejs-datepicker';
import axios from 'axios';
import _ from 'lodash';

export default {
  components: {TravelAllowanceAddList, Datepicker},
  props: {
    billTypes: {
      type: Array,
      required: true
    },
    bill: {
      type: Object
    },
    viewMode: {
      type: Boolean,
      default: false
    },
    mainPageUrl: {
      type: String,
      required: true
    },
    user: {
      type: Object,
      required: true
    },
    saveRoute: {
      type: String,
      required: true
    },
    viewRoute: {
      type: String,
      required: true
    },
    updateRoute: {
      type: String,
      required: true
    },
  },
  data() {
    return {
      tabs: [
        {
          name: 'ভ্রমণ ভাতা বিল',
          active: true
        },
        {
          name: 'দৈনিক ও যাতায়াত ভাতা',
          active: false
        },

      ],
      times: ['পূর্বাহ্ন', 'অপরাহ্ন'],
      travelTypes: ['সড়ক', 'বিমান'],
      travelBillTypes: [],
      form: {
        travelBill: {
          billType: null,
          fromPlace: null,
          fromDate: new Date(),
          fromTime: null,
          toPlace: null,
          toDate: new Date(),
          toTime: null,
          travelType: null,

          travelExpense: {
            class: null,
            costAmount: null,
            costCount: null,
          },
          travelAllowance: {
            costAmount: null,
            distance: null
          }
        },
        dailyBill: {}
      },
      dataList: []
    };
  },

  computed: {
    isSubmitted() {

      if (_.isEmpty(this.bill)) return false;

      return (this.bill.status.id === 3); // waiting for approval
    }
  },

  mounted() {
    this.getTravelBillTypes();
    this.mapData();
  },

  methods: {
    addData(e) {
      e.preventDefault();

      if (!this.validateAddForm()) {
        return confirm('দয়াকরে প্রয়োজনীয় ফিল্ড গুলি ভরাট করুন');
      }

      // add data
      this.dataList.push({...this.form, wantId: Date.now()});

      // empty the form
      this.form = {
        travelBill: {
          billType: this.form.travelBill.billType,
          fromPlace: null,
          fromDate: new Date(),
          fromTime: null,
          toPlace: null,
          toDate: new Date(),
          toTime: null,
          travelType: null,

          travelExpense: {
            class: null,
            costAmount: null,
            costCount: null,
          },
          travelAllowance: {
            costAmount: null,
            distance: null
          }
        },
        dailyBill: {}
      };
    },

    removeItemFromData(wantId) {
      this.dataList = this.dataList.filter(data => data.wantId !== wantId);
    },

    validateAddForm() {

      const requiredFields = [
        this.form.travelBill.billType,
        this.form.travelBill.fromPlace,
        this.form.travelBill.fromDate,
        this.form.travelBill.fromTime,
        this.form.travelBill.toPlace,
        this.form.travelBill.toDate,
        this.form.travelBill.toTime,
        this.form.travelBill.travelType,
      ];

      const requiredFieldsForTravelExpense = [
        this.form.travelBill.travelExpense.costAmount,
        this.form.travelBill.travelExpense.costCount,
      ];

      const requiredFieldsForTravelAllowance = [
        this.form.travelBill.travelAllowance.costAmount,
        this.form.travelBill.travelAllowance.distance,
      ];

      let requireds = [...requiredFields];

      if (this.form.travelBill.billType === 1) {
        requireds = [
          ...requireds,
          ...requiredFieldsForTravelAllowance
        ];
      } else {
        requireds = [
          ...requireds,
          ...requiredFieldsForTravelExpense
        ];
      }

      return !(requireds.filter(fieldValue => !(fieldValue)).length);
    },

    toggleTab(tab) {
      this.tabs.map(tb => {

        // make current tab active & other inactive
        tb.active = (tb.name === tab.name);

      });
    },

    getTravelBillTypes() {
      const types = this.billTypes.filter(type => type.name.includes('Travel'));
      this.travelBillTypes = types;
    },

    async handleAction(actionType) {
      if (!this.dataList.length) {
        return confirm('অনুগ্রহ করে কিছু ডাটা যোগ করে আবার চেষ্টা করুন');
      }

      // if action type reset
      if (actionType === 'reset') {
        if (confirm('আপনি কি ডাটা রিসেট অনুমোদন দিচ্ছেন ?')) this.dataList = [];
        return;
      }

      const data = {
        action: actionType,
        data: [...this.dataList]
      };

      const isSuccess = await this.sendData(data);

      // clear data after save
      if (isSuccess && !this.bill) this.dataList = [];

      // notify user
      const msg = (isSuccess) ? 'সফল ভাবে সম্পন্ন হয়েছে' : 'অজানা কারণে অ্যাকশন সফল হয়নি, দয়াকরে আবার চেষ্টা করুন';
      return confirm (msg);

    },

    async sendData(data) {
      try {

        let endpoint = (this.bill) ? `${this.updateRoute}/${this.bill.id}` : this.saveRoute;
        let method = (this.bill) ? 'patch' : 'post';

        await axios[method](endpoint, data);
        return true;

      } catch (e) {
          return false;
      }
    },

    mapData() {

      // dont map if bill not available
      if (!this.bill) return;

      // set datalist
      this.bill.details.map(detail => {
        this.dataList.push({
          wantId: detail.id,
          dailyBill: {},
          travelBill: {
            billType: detail.bill_type_id,
            fromPlace:  detail.start_from,
            fromDate: new Date(detail.start_date),
            fromTime: detail.start_time,
            toPlace:  detail.end_to,
            toDate: new Date(detail.end_date),
            toTime: detail.end_time,
            travelType: detail.travel_by,

            travelExpense: {
              class: detail.travel_class,
              costAmount: detail.fare_times,
              costCount: detail.fare,
            },
            travelAllowance: {
              costAmount: detail.allowance_rate,
              distance: detail.distance_travel
            }
          }
        });
      });

      // this.dataList = newDataList;

    }

  }
}
</script>
