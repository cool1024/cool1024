import { Page, PageServiceController } from './../../utils/page';

declare const $: any;

class ValueController extends PageServiceController {

    consoleStr: string;

    answerStr: string;

    constructor() {
        super();
        this.answerStr = '';
    }

    onInit() {
        this.consoleStr = `
........parseInt('.fdsfsad'); // ${ parseInt('.fdsfsad')}
        `;

        $('#answerBtn').click(() => {
            this.answerStr = `
............1.NaN是唯一一个非自反(自反，reflexive，即x === x不成立)的值。而NaN != NaN为 true,我们用isNaN()来判断这个值,当是要注意只要不是数字的值都会为false，无法真正确定是不是NaN这个值，
ES6提供了Number.isNaN(..)`;
            this.fillView();
        });

        this.fillView();
    }

    fillView() {
        $('#codeConsole').html(this.consoleStr);
        $('#answerPad').html(this.answerStr);
    }
}
Page.createAndInit(new ValueController);   
