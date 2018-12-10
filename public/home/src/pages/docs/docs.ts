import { Page, PageServiceController } from './../../utils/page';
import { Observable, Subject } from 'rxjs';
declare const $: any;

interface ApiConfig {
    server: string,
    title: string,
    headers: string[],
    docs: string[],
}

class DocsController extends PageServiceController {

    constructor() {
        super();
    }

    onInit() {
        // 加载配置文件
        this.loadJsonFile(`http://127.0.0.1:8080/source/docs/config.json?var=${Math.random()}`)
            .subscribe();
    }

    fillView() {

    }

    loadJsonFile(src: string): Observable<any> {
        const subject = new Subject<any>();
        $.ajax({
            url: src,
            success: (jsonStr: ApiConfig) => {

            },
            error: () => {
                console.log(`${src}文件加载失败`);
            }
        });
        return subject.asObservable();
    }
}
Page.createAndInit(new DocsController);   
