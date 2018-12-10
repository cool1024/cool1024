import { Page, PageServiceController } from './../../utils/page';

declare const $: any;

class ZoneController extends PageServiceController {

    title: string;

    cx: number;

    timerNum: number;

    updateTitle = () => {
        this.cx++;
        this.title = this.cx.toString();
    }

    constructor() {
        super();
        this.title = 'Example for zone.js';
        this.cx = 0;
    }

    onInit() {

        // test input keyup event
        $('#inputDom').keyup(event => {
            this.title = event.target.value;
        });

        // test button click event
        $('button.btn').click((event) => {
            this.title = event.target.innerHTML;
        });

        // test setInterval event
        $('a.btn').click((event) => {
            const target = event.target;
            if (target.innerHTML === 'setInterval') {
                target.innerHTML = 'closeInterval';
                this.timerNum = setInterval(() => {
                    this.cx++;
                    this.title = this.cx.toString();
                }, 500);
            } else {
                target.innerHTML = 'setInterval';
                clearInterval(this.timerNum);
            }
        });
    }

    fillView() {
        $('#headTitle').html(this.title);
    }
}
Page.create(new ZoneController);   
