import { SearchBox } from '../../lib';

export default function employeeSearch() {
  let searchBoxContainer = document.querySelector('.search-box');
  let searchResult = searchBoxContainer.querySelector('.result-body');

  let searchBox = new SearchBox(searchBoxContainer, searchResult, '/employees-affairs/search',
    (result) => {
      searchBox.searchResult.clear();
      let data = JSON.parse(result);
      Array.from(data).forEach((item) => {
        let itemElement = {
          text: item.name,
          attributes: [
            {
              name: 'class',
              value: 'list-item'
            }
          ],
          childElement: {
            type: 'a',
            attributes: [
              {
                name: 'href',
                value: `/employees-affairs/edit/${item.id}`
              },
              {
                name: 'class',
                value: 'link'
              }
            ]
          }
        };
        searchBox.searchResult.add(itemElement);
      });
    });
}