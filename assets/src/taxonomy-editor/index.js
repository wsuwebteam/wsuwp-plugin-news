import CustomTermSelector from './custom-term-selector';

function taxonomyEditor(OriginalComponent) {
	const supportedTaxonomies = ['media_contact', 'author'];

	return function (props) {
		if ( supportedTaxonomies.includes(props.slug) ) {
			return <CustomTermSelector {...props}></CustomTermSelector>
		}

		// default return
		return <OriginalComponent { ...props } />;
	}
}

wp.hooks.addFilter(
	'editor.PostTaxonomyType',
	'wsuwp-plugin-news',
	taxonomyEditor
);
