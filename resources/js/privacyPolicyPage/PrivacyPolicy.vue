<template>
    <div class="inner-block">
        <v-card>
            <v-row class="d-flex m-0" >
                <v-col ref="parent" cols="4" class="m-0" style="position: relative;"  v-scroll="handleScroll">
                    <aside ref="aside" class="aside privacy-navigation">
                        <v-list
                        max-width="350"
                        >
                            <v-list-item 
                            v-for="(text, index) in text" 
                            :key="index" 
                            @click="scrollToSection(item)">
                                <v-list-item-title class="privacy-navigation-link">
                                    {{index !== 0 ? `${index}. ${text.title}` : text.title}}
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </aside>
                </v-col>
               <v-col class="m-0">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero reiciendis autem veniam quis fugiat, veritatis sapiente optio explicabo voluptatum, molestiae id in ea, laudantium architecto asperiores assumenda. Quos aperiam quam nobis quisquam, praesentium corrupti molestiae natus dolores reprehenderit vel incidunt ipsam doloribus ratione! Beatae unde ullam neque sapiente dolor quod! Fugit quo, sapiente itaque quibusdam ipsam ratione atque ducimus repellat minima. Mollitia ut molestiae perspiciatis corporis nulla eaque consectetur eius dicta voluptate ipsa? Cum ad distinctio est quaerat, dolor ea dolore, libero culpa odit enim hic aut cumque nostrum blanditiis suscipit et dolorem praesentium labore! Veritatis corrupti et culpa odio accusantium. Veritatis facere ex quae quasi tempora nam! Dolore velit eveniet ea similique cupiditate cum aliquid eos praesentium vel corrupti blanditiis, ad fugiat non magnam, mollitia delectus nisi consequatur voluptatum doloremque. Quasi accusamus vel excepturi a eaque nobis corporis beatae! Ullam nostrum sequi odio laboriosam magnam error vero autem nobis praesentium quidem nulla sit, soluta facere in deleniti tenetur optio hic suscipit repellendus architecto. Expedita eius vitae eos pariatur rerum aliquam culpa debitis maxime. Dignissimos animi cumque natus, iure error libero alias praesentium veniam non harum pariatur accusantium perferendis tempora, culpa ex? Quibusdam eius commodi corrupti ducimus aut natus aliquid et quae quia illo repellat iure deleniti dignissimos cumque tempore libero maiores atque dolores, vel fugiat voluptas porro odio. Nobis vero autem dolores sequi distinctio reprehenderit unde, alias quam aliquid. Deleniti labore, laborum unde dolore harum accusamus inventore corporis dicta hic sequi fugiat error. Eaque perferendis quaerat optio provident illum natus possimus vel cupiditate esse nobis dolor magnam, similique quos deserunt iste qui tenetur voluptatibus animi unde enim atque quisquam est? Itaque iste, architecto error aliquid, corporis vitae quos, neque deserunt fuga ratione inventore! Illo ea odit ipsum, corrupti atque amet, commodi qui dicta tempore quod ratione vitae nisi similique sequi. Vitae esse inventore quia quaerat, animi mollitia minima velit modi, repellat ab ut eos cumque neque dolores sequi doloremque, ducimus voluptas hic. Repellat exercitationem consequuntur magnam dolorum totam eveniet quas laborum quos debitis architecto voluptates temporibus, incidunt deserunt ex accusantium magni unde, aut reprehenderit eos doloribus! Error aut nostrum iusto cumque, vero culpa omnis quidem. Quisquam repudiandae modi consequuntur ipsum esse perferendis aspernatur nisi dolor, accusantium distinctio quae aperiam maiores sequi eaque? Eligendi porro vero optio ea aut, nisi soluta veritatis praesentium sit repudiandae autem facere dolore harum tempore nobis officiis velit? Debitis optio odit nemo harum dolores, quas soluta cumque ullam rem suscipit culpa iste dolore provident, eaque maxime voluptates aspernatur deleniti quo. Quae repudiandae enim asperiores ducimus deserunt cupiditate corrupti deleniti in. Aliquid accusamus consequuntur, voluptas quis cupiditate ad? Adipisci id laboriosam vitae nisi mollitia fugit aliquam perferendis ut saepe dolores quo temporibus magnam laudantium, iste minima vero velit minus cupiditate itaque recusandae. Voluptatem culpa modi in quas quaerat. Omnis quos expedita perspiciatis earum amet asperiores natus beatae incidunt voluptatum rem facere voluptas, blanditiis suscipit quidem magnam aliquam ad vero, quis illum sed possimus delectus? Iure eligendi unde tempora sint excepturi corporis architecto quia eos? Delectus, dolores?</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero reiciendis autem veniam quis fugiat, veritatis sapiente optio explicabo voluptatum, molestiae id in ea, laudantium architecto asperiores assumenda. Quos aperiam quam nobis quisquam, praesentium corrupti molestiae natus dolores reprehenderit vel incidunt ipsam doloribus ratione! Beatae unde ullam neque sapiente dolor quod! Fugit quo, sapiente itaque quibusdam ipsam ratione atque ducimus repellat minima. Mollitia ut molestiae perspiciatis corporis nulla eaque consectetur eius dicta voluptate ipsa? Cum ad distinctio est quaerat, dolor ea dolore, libero culpa odit enim hic aut cumque nostrum blanditiis suscipit et dolorem praesentium labore! Veritatis corrupti et culpa odio accusantium. Veritatis facere ex quae quasi tempora nam! Dolore velit eveniet ea similique cupiditate cum aliquid eos praesentium vel corrupti blanditiis, ad fugiat non magnam, mollitia delectus nisi consequatur voluptatum doloremque. Quasi accusamus vel excepturi a eaque nobis corporis beatae! Ullam nostrum sequi odio laboriosam magnam error vero autem nobis praesentium quidem nulla sit, soluta facere in deleniti tenetur optio hic suscipit repellendus architecto. Expedita eius vitae eos pariatur rerum aliquam culpa debitis maxime. Dignissimos animi cumque natus, iure error libero alias praesentium veniam non harum pariatur accusantium perferendis tempora, culpa ex? Quibusdam eius commodi corrupti ducimus aut natus aliquid et quae quia illo repellat iure deleniti dignissimos cumque tempore libero maiores atque dolores, vel fugiat voluptas porro odio. Nobis vero autem dolores sequi distinctio reprehenderit unde, alias quam aliquid. Deleniti labore, laborum unde dolore harum accusamus inventore corporis dicta hic sequi fugiat error. Eaque perferendis quaerat optio provident illum natus possimus vel cupiditate esse nobis dolor magnam, similique quos deserunt iste qui tenetur voluptatibus animi unde enim atque quisquam est? Itaque iste, architecto error aliquid, corporis vitae quos, neque deserunt fuga ratione inventore! Illo ea odit ipsum, corrupti atque amet, commodi qui dicta tempore quod ratione vitae nisi similique sequi. Vitae esse inventore quia quaerat, animi mollitia minima velit modi, repellat ab ut eos cumque neque dolores sequi doloremque, ducimus voluptas hic. Repellat exercitationem consequuntur magnam dolorum totam eveniet quas laborum quos debitis architecto voluptates temporibus, incidunt deserunt ex accusantium magni unde, aut reprehenderit eos doloribus! Error aut nostrum iusto cumque, vero culpa omnis quidem. Quisquam repudiandae modi consequuntur ipsum esse perferendis aspernatur nisi dolor, accusantium distinctio quae aperiam maiores sequi eaque? Eligendi porro vero optio ea aut, nisi soluta veritatis praesentium sit repudiandae autem facere dolore harum tempore nobis officiis velit? Debitis optio odit nemo harum dolores, quas soluta cumque ullam rem suscipit culpa iste dolore provident, eaque maxime voluptates aspernatur deleniti quo. Quae repudiandae enim asperiores ducimus deserunt cupiditate corrupti deleniti in. Aliquid accusamus consequuntur, voluptas quis cupiditate ad? Adipisci id laboriosam vitae nisi mollitia fugit aliquam perferendis ut saepe dolores quo temporibus magnam laudantium, iste minima vero velit minus cupiditate itaque recusandae. Voluptatem culpa modi in quas quaerat. Omnis quos expedita perspiciatis earum amet asperiores natus beatae incidunt voluptatum rem facere voluptas, blanditiis suscipit quidem magnam aliquam ad vero, quis illum sed possimus delectus? Iure eligendi unde tempora sint excepturi corporis architecto quia eos? Delectus, dolores?</p>
               </v-col>
            </v-row>
        </v-card>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                text: [
                    {title: 'Introduction'},
                    {title: 'Interpretation and Definitions'},
                    {title: 'Collecting and Using Your Personal Data'},
                    {title: 'Children\'s Privacy'},
                    {title: 'Links to Other Websites'},
                    {title: 'Changes to this Privacy Policy'},
                    {title: 'Contact Us'},
                ]
            }
        },
        methods: {
            handleScroll() {
                const parentRect = this.$refs.parent.getBoundingClientRect();
                const asideRect = this.$refs.aside.getBoundingClientRect();

                if (asideRect.top < parentRect.top) {
                    this.$refs.aside.style.top = `${parentRect.top}px`; // Если aside находится выше родительского элемента
                } 
                if (asideRect.bottom > parentRect.bottom) {
                    this.$refs.aside.style.top = `${parentRect.bottom - asideRect.height}px`; // Если aside находится ниже родительского элемента
                }
            },

            onResize() {
                this.handleScroll();
            }
        },
            mounted() {
                this.handleScroll();
                window.addEventListener('resize', this.onResize);
            },

            beforeDestroy() {
                window.removeEventListener('resize', this.onResize);
            },
    }
</script>

<style scoped>
      @import url('/css/privacyPolicyPage/privacyPolicyPage.css');
</style>