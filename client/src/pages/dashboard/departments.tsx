import { useEffect, useMemo, useState } from "react";
import { parseVar } from "@/services/parseVar";
import { CategoriesCounter, Deparment } from "./type";
import { DepartmentStyled, SeeMoreStyle } from "./style";
import { Badge } from "antd";
import * as changeCase from "change-case";
import {
  getTotal,
  sortByHighestCategoryListItem,
  sortByHighestCategoryList,
} from "./service";
import { getColorByIndex } from "../../services/color";
import { getIcon } from "../../services/icon";

function Deparments() {
  const [categorization, setCategorization] = useState<CategoriesCounter>({});
  const [showCategorySeeMore, setShowCategorySeeMore] = useState<{
    [key: string]: boolean;
  }>({});

  useEffect(() => {
    // @ts-ignore
    const counter = parseVar(
      // @ts-ignore
      window.employeeCategorisationCounter,
    ) as CategoriesCounter;
    // @ts-ignore
    const attendance = parseVar(window.totalAttendance);

    if (attendance) {
      setCategorization({
        ...counter,
        ...{
          attendance: attendance,
        },
      });
    }
  }, []);

  const handleSeeMore = (categoryKey: string, showMore = true) => {
    return () => {
      setShowCategorySeeMore({
        ...showCategorySeeMore,
        ...{
          [categoryKey]: showMore,
        },
      });
    };
  };

  const [colors, setColors] = useState<{ [key: number]: string }>({});
  const getColor = (index: number) => {
    const newColor = getColorByIndex(index);
    if (colors[index]) {
      return colors[index];
    }
    setColors({
      ...colors,
      ...{ [index]: newColor },
    });
    return newColor;
  };

  return (
    <>
      {sortByHighestCategoryList(categorization).map(
        ([categoryKey, values], index) => {
          const color = getColor(index);
          const categoryList = categorization[categoryKey];
          const tooManyList = Object.keys(values).length > 20;
          const columnClasses = tooManyList
            ? "col-xs-12 col-md-6"
            : "col-md-4 col-lg-3 col-xs-12";
          return (
            <DepartmentStyled key={categoryKey + index}>
              <div className={columnClasses} key={index}>
                <Badge.Ribbon text={getTotal(categoryList)} color="#d3d3d3">
                  <div className="white-box analytics-info">
                    <h3 className="box-title">
                      {getIcon(categoryKey)}
                      {changeCase.sentenceCase(categoryKey)}&nbsp;
                    </h3>
                    {(() => {
                      const showMore = showCategorySeeMore[categoryKey];
                      const sortedList =
                        sortByHighestCategoryListItem(categoryList);
                      const list =
                        showMore === true
                          ? sortedList
                          : sortedList.slice(0, 20);

                      return list
                        .map(([categoryKey, count]) => {
                          return (
                            <Badge
                              title={categoryKey}
                              count={count}
                              color={color}
                              showZero
                              overflowCount={9999}
                            >
                              <div title={categoryKey}>{categoryKey}</div>
                            </Badge>
                          );
                        })
                        .concat([
                          tooManyList ? (
                            !showMore ? (
                              <SeeMoreStyle
                                onClick={handleSeeMore(categoryKey)}
                              >
                                See {sortedList.length - 20} More
                              </SeeMoreStyle>
                            ) : (
                              <SeeMoreStyle
                                onClick={handleSeeMore(categoryKey, false)}
                              >
                                Show less
                              </SeeMoreStyle>
                            )
                          ) : (
                            <></>
                          ),
                        ]);
                    })()}
                  </div>
                </Badge.Ribbon>
              </div>
            </DepartmentStyled>
          );
        },
      )}
    </>
  );
}

export default Deparments;
