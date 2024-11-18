import { Button, Col, Row } from "antd";
import trim from "string.prototype.trim";
import AutoCompleteField from "../AutoCompleteField";
import {
  JSX,
  ReactElement,
  ReactNode,
  useEffect,
  useMemo,
  useRef,
  useState,
} from "react";
import { FilterOptions, getFiltersAsOptions } from "../../services/filters";
import $ from "jquery";
import {
  AdvanceSearchStyled,
  AdvanceSearchWrapperStyled,
  ToolbarStyled,
} from "./style";
import { AdvanceSearchApiProps, SearchCriteria } from "./type";
import {
  ClearOutlined,
  PrinterOutlined,
  SearchOutlined,
} from "@ant-design/icons";
import { useUrlParams } from "../../services/useUrlParams";
import pluralize from "pluralize";

interface AdvanceSearchProps {
  printEndpoint?: string;
  submitPath?: string;
  prependElements?: (api: AdvanceSearchApiProps) => ReactElement;
  formId?: string;
  onSearch?: (queryParams: string) => unknown;
}

function AdvanceSearch({
  printEndpoint,
  submitPath,
  prependElements,
  formId,
  onSearch,
}: AdvanceSearchProps) {
  const [fields, setFields] = useState<FilterOptions>([]);
  const [searchCriteria, setSearchCriteria] = useState<SearchCriteria>({});
  const [reset, setReset] = useState(false);

  const [disableSearch, setDisableSearch] = useState(true);
  const urlParams = useUrlParams();

  const searchUrl = useMemo(() => {
    const url = Object.keys(searchCriteria)
      .map((searchKey) =>
        [
          pluralize.singular(searchKey.toLowerCase()),
          trim(searchCriteria[searchKey]),
        ].join("="),
      )
      .join("&");
    return url;
  }, [searchCriteria]);

  const submit = () => {
    const submit = document.getElementById("react-filter-button");
    submit && submit.click();
  };

  useEffect(() => {
    if (reset) {
      updateForm();
      setReset(false);
    }
  }, [searchUrl]);

  const updateForm = () => {
    const form =
      formId && (document.getElementById(String(formId)) as HTMLFormElement);
    if (form) {
      form.action = submitPath + "?" + searchUrl;
    }
  };

  const handleSearch = () => {
    if (onSearch) {
      onSearch(searchUrl);
    }
    if (!submitPath) {
      $.ajax(`?page=1&` + searchUrl, {
        headers: {},
      })
        .done(function (data) {
          $(".data").html(data);
          $("html, body").animate({ scrollTop: 0 }, 800);
        })
        .fail(function () {
          alert("No response from server");
        });
    } else if (!window.location.href.match(searchUrl)) {
      updateForm();
    }
  };

  useEffect(() => {
    getFiltersAsOptions().then((response) => {
      setFields(response);
    });
  }, []);

  const searchTimeoutId = useRef(0);

  useEffect(() => {
    clearTimeout(searchTimeoutId.current);
    if (!disableSearch) {
      searchTimeoutId.current = setTimeout(() => {
        handleSearch();
      }, 500) as any;
    }
  }, [searchUrl]);

  useEffect(() => {
    if (disableSearch && Object.values(urlParams).length) {
      let searchCriteria: SearchCriteria = {};
      if (urlParams) {
        Object.keys(urlParams).forEach((paramKey) => {
          const value = urlParams[paramKey];
          if (value) {
            searchCriteria[String(paramKey)] = value;
          }
        });
        setSearchCriteria({ ...searchCriteria });
      }
    }
    setTimeout(() => setDisableSearch(false), 1000);
  }, [urlParams]);

  const extraButtons = useMemo(
    () => [printEndpoint, submitPath].filter((value) => value),
    [printEndpoint, submitPath],
  );
  const searchSpan = useMemo(() => 20, [printEndpoint]);

  const PrependElements = (props: AdvanceSearchApiProps): JSX.Element => {
    if (prependElements !== undefined) {
      return prependElements(props);
    }
    return <></>;
  };

  const handleReset = () => {
    Object.keys(searchCriteria).forEach((searchKey) => {
      searchCriteria[searchKey] = "";
      const elements = Object.values(
        document.getElementsByName(searchKey) as NodeListOf<HTMLInputElement>,
      );
      if (elements.length) {
        elements.forEach((element) => {
          element.value = "";
          element.click();
        });
      }
    });
    setSearchCriteria({ ...searchCriteria });
    setTimeout(() => {
      setReset(true);
    }, 500);
  };

  const handleSelect = () => {
    setTimeout(() => {
      submit();
    }, 600);
  };

  const autoFilterTimeoutId = useRef(0);

  useEffect(() => {
    if (!submitPath) {
      return;
    }
    clearTimeout(autoFilterTimeoutId.current);
    autoFilterTimeoutId.current = setTimeout(() => {
      if (Object.values(urlParams).length === 0) {
        document.getElementById("react-filter-button")?.click();
      }
    }, 200) as any;
  }, [urlParams]);

  return (
    <AdvanceSearchWrapperStyled>
      <Col span={searchSpan}>
        <AdvanceSearchStyled>
          <label>Filter</label>
          <Row>
            <PrependElements
              searchCriteriaState={[searchCriteria, setSearchCriteria]}
            ></PrependElements>
            {Object.values(fields).map((field, key) => {
              const singularFieldText = pluralize.singular(
                field.text.toLowerCase(),
              );
              return (
                <Col span={6} key={key}>
                  <input
                    type="hidden"
                    name={singularFieldText}
                    value={searchCriteria[singularFieldText]}
                  />
                  <AutoCompleteField
                    options={field.options || []}
                    placeholder={field.text}
                    label={field.text}
                    name={singularFieldText}
                    value={searchCriteria[singularFieldText]}
                    onSearch={(searchKey: string | number) => {
                      if (disableSearch) {
                        return;
                      }

                      let criteria: SearchCriteria = {};
                      criteria[singularFieldText] = searchKey;

                      setSearchCriteria({
                        ...searchCriteria,
                        ...criteria,
                      });
                    }}
                    onSelect={handleSelect}
                  />
                </Col>
              );
            })}
          </Row>
        </AdvanceSearchStyled>
      </Col>
      <Col span={4}>
        <ToolbarStyled>
          {printEndpoint && (
            <Button
              type="primary"
              color="purple"
              href={printEndpoint + "?" + searchUrl}
              target="_blank"
            >
              <PrinterOutlined />
              Print
            </Button>
          )}
          {submitPath && (
            <Button
              id="react-filter-button"
              type="primary"
              color="purple"
              target="_self"
              htmlType="submit"
              value="filter"
            >
              <SearchOutlined />
              Filter
            </Button>
          )}
          <Button type="primary" danger htmlType="reset" onClick={handleReset}>
            <ClearOutlined />
            Reset
          </Button>
        </ToolbarStyled>
      </Col>
    </AdvanceSearchWrapperStyled>
  );
}

export default AdvanceSearch;
