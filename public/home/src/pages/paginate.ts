export class Pagination {
    constructor(public total: number = 0, public page: number = 1, public limit = 10) { }

    get offset(): number {
        return (this.page - 1) * this.limit;
    }

    get pageData(): { [key: string]: number } {
        return { limit: this.limit, offset: this.offset };
    }

    get maxPage(): number {
        return Math.ceil(this.total / this.limit);
    }

    getpageDataWith(params: any = {}): { limit: number, offset: number, [key: string]: string | number } {
        params.limit = this.limit;
        params.offset = this.offset;
        return params;
    }

    reset(): void {
        this.total = 0;
        this.page = 1;
        this.limit = 10;
    }

    hasNext(): boolean {
        return this.page < this.maxPage;
    }

    hasPrev(): boolean {
        return this.page > 1;
    }

    hasPage(page: number) {
        return page > 0 && page <= this.maxPage;
    }

    clone(): Pagination {
        return new Pagination(this.total, this.page, this.limit);
    }

    getPaginationHtml(): string {
        let lis = '';
        for (let i = 1; i <= this.maxPage; i++) {
            lis += `<li class="${i !== this.page || 'active'}"><a href="#fakelink" onclick="Page.goPage(${i})">${i}</a></li>`;
        }

        return `
        <li class="previous">
            <a onclick="Page.prevPage()" class="fui-arrow-left"></a>
        </li>
        ${lis}
        <li class="next">
            <a onclick="Page.nextPage()" class="fui-arrow-right"></a>
        </li>`;
    }
}

export interface PageCtrl {
    prevPage(): void;
    nextPage(): void;
    goPage(index: number): void;

}