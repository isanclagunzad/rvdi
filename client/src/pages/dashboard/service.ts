import { CategoriesCounter, CategoryCount } from "./type";

export const sortByHighestCategoryListItem = (categoryList: CategoryCount) => {
  return Object.entries(categoryList).sort((categoryA, categoryB) => {
    return Number(categoryB[1]) - Number(categoryA[1]);
  });
};

export const sortByHighestCategoryList = (category: CategoriesCounter) => {
  return Object.entries(category).sort((categoryA, categoryB) => {
    return (
      Object.values(categoryB[1]).length - Object.values(categoryA[1]).length
    );
  });
};

export const getTotal = (categoryList: CategoryCount) => {
  return Object.entries(categoryList).reduce((accumulator, currentValue) => {
    return accumulator + Number(currentValue[1]);
  }, 0);
};
