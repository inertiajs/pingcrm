<template>
  <v-app id="inspire">
    <v-app-bar app color="#151635" dark>
      <v-app-bar-nav-icon href="https://terrentro.com/" />

      <v-toolbar-title
        class="text-subtitle-1 text-md-h5 text-uppercase"
        style="color:#d61523;"
      >
        Simulador Terrentro
      </v-toolbar-title>

      <v-spacer />

      <v-btn icon @click="print">
        <v-icon>mdi-printer</v-icon>
      </v-btn>
    </v-app-bar>

    <v-main class="grey lighten-3">
      <v-container>
        <v-row>
          <v-col cols="12" sm="10" offset-sm="1">
            <v-sheet min-height="70vh" rounded="lg">
              <v-container>
                <v-row
                  class="d-flex flex-wrap justify-space-between pa-3 ma-2 grey lighten-5"
                >
                  <v-text-field
                    v-model="amount"
                    label="Valor Con IVA:"
                    type="number"
                    class="mx-2 flex-grow-1 flex-shrink-1"
                    prefix="$"
                    outlined
                    dense
                  />
                  <v-text-field
                    v-model="firmas"
                    label="Ratificacion de Firmas:"
                    type="number"
                    class="mx-2 "
                    prefix="$"
                    outlined
                    dense
                  />
                  <v-text-field
                    v-model="seguro"
                    label="Seguro:"
                    type="number"
                    class="mx-2 flex-grow-1 flex-shrink-1"
                    prefix="$"
                    outlined
                    dense
                  />
                  <v-text-field
                    label="Otros:"
                    type="number"
                    class="mx-2 flex-grow-1 flex-shrink-1"
                    prefix="$"
                    outlined
                    disabled
                    dense
                  />

                  <v-col
                    cols="6"
                    md="2"
                    class="mx-2 flex-grow-1 flex-shrink-0 pa-0"
                  >
                    <v-select
                      v-model="rents"
                      label="Rentas Anticipadas:"
                      class="mx-2 flex-grow-0 flex-shrink-0"
                      :items="anticipated"
                      item-text="mes"
                      prefix="#"
                      outlined
                      reverse
                      dense
                      return-object
                    />
                  </v-col>
                </v-row>
                <v-simple-table dense>
                  <thead>
                    <tr>
                      <th>Plazo (MESES)</th>
                      <th
                        v-for="({ mes }, i) in Mensualidades"
                        :key="i"
                        class="text-body-1 font-weight-bold text-center"
                      >
                        {{ mes }}
                      </th>
                    </tr>
                  </thead>

                  <tbody class="text-body-1">
                    <tr v-for="(row, i) in operaciones" :key="`reowopps-${i}`">
                      <td v-text="row.name" />
                      <td
                        v-for="(config, index) in Mensualidades"
                        :key="`opps-${index}`"
                        class="text-center font-weight-bold"
                      >
                        <template v-if="i == 0">
                          ${{ aperturaContrato }}
                        </template>
                        <template v-if="i == 1">
                          ${{ parseInt(firmas).toFixed(2) }}
                        </template>
                        <template v-if="i == 2">
                          ${{ parseInt(seguro).toFixed(2) }}
                        </template>
                        <template
                          v-if="!!row.cb && typeof row.cb === 'function'"
                        >
                          ${{
                            Math.round(
                              row.cb({
                                ...config,
                                ...rents,
                              })
                            )
                          }}
                        </template>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="6">
                        <v-divider class="my-3" />
                      </td>
                    </tr>
                    <tr
                      v-for="(row, i) in conclusiones"
                      :key="`ccl-${i}`"
                      class="green lighten-5"
                    >
                      <td style="border: 1px solid black;" v-text="row.name" />
                      <td
                        v-for="(config, index) in Mensualidades"
                        :key="`cclmes-${index}`"
                        class="text-center font-weight-bold"
                        style="border: 1px solid black;"
                      >
                        <template
                          v-if="!!row.cb && typeof row.cb === 'function'"
                        >
                          ${{
                            Math.round(
                              row.cb({
                                ...config,
                                ...rents,
                                meses: config.mes - rents.mes,
                              })
                            )
                          }}
                        </template>
                      </td>
                    </tr>
                  </tbody>
                </v-simple-table>
              </v-container>
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    amount: 1225000,
    apertura: 24500,
    firmas: 6800,
    seguro: 0,
    otros: 0,
    anticipated: [
      { mes: 0, percent: 0 },
      { mes: 1, percent: 0 },
      { mes: 2, percent: 0 },
      { mes: 3, percent: 3.0 },
      { mes: 4, percent: 3.5 },
      { mes: 5, percent: 4.0 },
      { mes: 6, percent: 4.5 },
      { mes: 7, percent: 5.0 },
      { mes: 8, percent: 5.5 },
      { mes: 9, percent: 6.0 },
      { mes: 10, percent: 6.5 },
      { mes: 11, percent: 7.0 },
      { mes: 12, percent: 7.5 },
      { mes: 13, percent: 8.0 },
    ],
    rents: { mes: 2, percent: 0 },
  }),
  computed: {
    Mensualidades() {
      return [
        {
          mes: 12,
          tax: 0.059,
          tax2: 1.06,
          tax3: 0.12,
          percent_unid: 0.35,
          annual: 1,
        },
        {
          mes: 18,
          tax: 0.048,
          tax2: 1.06,
          tax3: 0.18,
          percent_unid: 0.25,
          annual: 2,
        },
        {
          mes: 24,
          tax: 0.0425,
          tax2: 1.06,
          tax3: 0.22,
          percent_unid: 0.2,
          annual: 2,
        },
        {
          mes: 36,
          tax: 0.0315,
          tax2: 1.25,
          tax3: 0.34,
          percent_unid: 0.15,
          annual: 3,
        },
        {
          mes: 48,
          tax: 0.0253,
          tax2: 1.3,
          tax3: 0.42,
          percent_unid: 0.1,
          annual: 4,
        },
      ]
    },
    operaciones() {
      return [
        { name: 'Apertura de Contrato' },
        { name: 'Ratificacion de Firmas' },
        { name: 'Seguro Anual' },
        {
          name: `Rentas en Desposito (${this.rents.mes})`,
          cb: params => {
            return this.rentas_en_deposito(params)
          },
        },
        {
          name: 'Subtotal Pago Inicial',
          cb: params => {
            return this.subtotal_pago_inicial(params)
          },
        },
        {
          name: 'IVA',
          cb: params => {
            return this.iva(params)
          },
        },
        {
          name: 'Total Pago Inicial',
          cb: params => {
            return this.total_pago_inicial(params)
          },
        },
        {
          name: 'Pago Mensual de Renta sin IVA',
          cb: params => {
            return this.pago_mensual_sin_iva(params)
          },
        },
        {
          name: 'Valor del Equipo al Final sin IVA',
          cb: params => {
            return this.valor_equipo_final_contrato_sin_iva(params.percent_unid)
          },
        },
      ]
    },
    conclusiones() {
      return [
        {
          name: 'Total de Pago',
          cb: params => {
            return (
              this.total_pago_inicial(params) +
              this.pago_mensual_sin_iva(params) * 1.16 * params.meses +
              this.valor_equipo_final_contrato_sin_iva(params.percent_unid)
            )
          },
        },
        {
          name: 'Utilidad Bruta',
          cb: params => {
            return this.utilidad_bruta(params)
          },
        },
        {
          name: 'Costo de Intereses',
          cb: params => {
            return this.costo_interes(params)
          },
        },
        {
          name: 'Utilidad Neta',
          cb: params => {
            return this.ultilidad_neta(params)
          },
        },
        {
          name: 'Utilidad Mensual',
          cb: params => {
            return this.utilidad_mensual(params)
          },
        },
      ]
    },
    aperturaContrato() {
      return this.amount * 0.02
    },
  },
  methods: {
    utilidad_mensual(params) {
      return this.ultilidad_neta(params) / params.mes
    },
    ultilidad_neta(params) {
      return this.utilidad_bruta(params) - this.costo_interes(params)
    },
    costo_interes({ tax3 }) {
      return this.amount * tax3
    },
    utilidad_bruta(params) {
      return this.pago_total(params) - this.amount
    },
    pago_total(params) {
      let pagos_mes_con_iva = this.pago_mensual_sin_iva(params) * 1.16
      return (
        this.total_pago_inicial(params) +
        pagos_mes_con_iva * params.meses +
        this.valor_equipo_final_contrato_sin_iva(params.percent_unid)
      )
    },
    valor_equipo_final_contrato_sin_iva(percent_unid) {
      return this.amount * percent_unid
    },
    total_pago_inicial(params) {
      return this.subtotal_pago_inicial(params) + this.iva(params)
    },
    iva(params) {
      return this.subtotal_pago_inicial(params) * 0.16
    },
    subtotal_pago_inicial(params) {
      return this._subtotal(params) + this.rentas_en_deposito(params)
    },
    _subtotal(params) {
      let annual = parseInt(this.seguro) * params.annual
      return this.aperturaContrato + parseInt(this.firmas) + annual
    },
    rentas_en_deposito(params) {
      return this.pago_mensual_sin_iva(params) * this.rents.mes
    },
    pago_mensual_sin_iva({ tax, tax2, percent }) {
      return this.amount * tax * (1 - percent / 100) * tax2
    },
    print() {
      window.print()
    },
  },
}
</script>
<style></style>
