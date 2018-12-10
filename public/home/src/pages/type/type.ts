import { Page, PageServiceController } from './../../utils/page';

declare const $: any;

class TypeController extends PageServiceController {

    consoleStr: string;

    answerStr: string;

    constructor() {
        super();
        this.answerStr = '';
    }

    onInit() {

        this.consoleStr = `
........typeof undefined === 'undefined'  // ${typeof undefined === 'undefined'}
........typeof true === 'boolean'         // ${typeof true === 'boolean'}
........typeof 1 === 'number'             // ${typeof 1 === 'number'}
........typeof 'hello world' === 'string' // ${typeof 'hello world' === 'string'}
........typeof { life: 42 } === 'object'  // ${typeof { life: 42 } === 'object'}
........typeof Symbol() === 'symbol'      // ${typeof Symbol() === 'symbol'}
........typeof null === 'object'          // ${typeof null === 'object'}
        `;

        $('#answerBtn').click(() => {
            this.answerStr = `
............1.判断null
............var a = null;
............(!a && typeof a === 'object'); // ${!null && typeof null === 'object'}
............2.数组是object的‘子类型’
............3.function也是object的‘子类型’，一个可调用对象，但是typeof结果是function
............typeof function a(){ /* .. */ } === "function"; // ${typeof function a() { /* .. */ } === "function"}
            `;
            this.fillView();
        });

        this.fillView();
    }

    showAnswer(event: any) {
        const pDom: HTMLParagraphElement = event.target.parentNode;
        pDom.innerHTML += `
        
        `
    }

    fillView() {
        $('#codeConsole').html(this.consoleStr);
        $('#answerPad').html(this.answerStr);
    }
}
Page.createAndInit(new TypeController);   
