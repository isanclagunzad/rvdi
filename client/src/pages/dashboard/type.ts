export interface Deparment {
  name: string;
  count: number;
}

export interface CategoryCount {
  [key: string]: `${number}`;
}

export interface CategoriesCounter {
  [key: string]: CategoryCount;
}
