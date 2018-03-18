export interface ArticleLabel {
    id: number;
    article_label_level: number;
    article_label_name: string;
}

export interface Article {
    id: number;
    article_title: string;
    article_label_id: number;
    article_content: string;
    article_thumb: string;
    created_at: string;
    updated_at: string;
}