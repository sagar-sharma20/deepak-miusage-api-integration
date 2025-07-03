/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls } from '@wordpress/block-editor';

import { PanelBody, ToggleControl, Spinner } from '@wordpress/components';

import { useState, useEffect } from '@wordpress/element';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
  const {
    showID,
    showFirstName,
    showLastName,
    showEmail,
    showDate,
  } = attributes;

  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    wp.apiFetch({ path: '/deepak-miusage/v1/data/' })
      .then((res) => {
        const rows = res?.data?.data?.rows || {};
        setData(Object.values(rows));
        setLoading(false);
      })
      .catch(() => setLoading(false));
  }, []);

  return (
    <>
      <InspectorControls>
        <PanelBody title="Toggle Columns">
          <ToggleControl label="Show ID" checked={showID} onChange={(val) => setAttributes({ showID: val })} />
          <ToggleControl label="Show First Name" checked={showFirstName} onChange={(val) => setAttributes({ showFirstName: val })} />
          <ToggleControl label="Show Last Name" checked={showLastName} onChange={(val) => setAttributes({ showLastName: val })} />
          <ToggleControl label="Show Email" checked={showEmail} onChange={(val) => setAttributes({ showEmail: val })} />
          <ToggleControl label="Show Date" checked={showDate} onChange={(val) => setAttributes({ showDate: val })} />
        </PanelBody>
      </InspectorControls>

      <div className="miusage-table-block">
        {loading ? (
          <Spinner />
        ) : (
          <table>
            <thead>
              <tr>
                {showID && <th>ID</th>}
                {showFirstName && <th>First Name</th>}
                {showLastName && <th>Last Name</th>}
                {showEmail && <th>Email</th>}
                {showDate && <th>Date</th>}
              </tr>
            </thead>
            <tbody>
              {data.map((row, i) => (
                <tr key={i}>
                  {showID && <td>{row.id}</td>}
                  {showFirstName && <td>{row.fname}</td>}
                  {showLastName && <td>{row.lname}</td>}
                  {showEmail && <td>{row.email}</td>}
                  {showDate && <td>{new Date(row.date * 1000).toLocaleString()}</td>}
                </tr>
              ))}
            </tbody>
          </table>
        )}
      </div>
    </>
  );
}
